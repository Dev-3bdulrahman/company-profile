<?php

namespace App\Services\Internal;

use App\Models\Lead;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;

class ContactService extends BaseInternalService
{
    public function handleContactMessage(array $data, string $ip): bool
    {
        // 1. Save Lead to DB
        $locationData = $this->getLocationFromIp($ip);
        Lead::create([
            'name'       => strip_tags($data['name']),
            'email'      => filter_var($data['email'], FILTER_SANITIZE_EMAIL),
            'subject'    => $data['subject'] ?? __('New Message'),
            'message'    => strip_tags($data['message']),
            'ip_address' => $ip,
            'country'    => $locationData['country'] ?? null,
            'city'       => $locationData['city'] ?? null,
            'status'     => 'new',
        ]);

        // 2. Rate limit email notifications
        $key = 'contact-msg-email:' . $ip;
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return true; // Return true because lead is saved
        }
        RateLimiter::hit($key, 3600);

        // 3. Send Notifications
        $this->sendEmailNotifications($data, $ip);

        return true;
    }

    public function sendHireRequest(string $ip): bool
    {
        $toEmail = SiteSetting::getValue('contact_email');
        if (!$toEmail) {
            return false;
        }

        Mail::raw(
            __('A visitor from :ip is interested in hiring you! They clicked the "Hire Me" button on your portfolio.', ['ip' => $ip]),
            function ($message) use ($toEmail) {
                $message->to($toEmail)
                    ->subject(__('New Hire Request from Portfolio'));
            }
        );

        return true;
    }

    private function getLocationFromIp(string $ip): array
    {
        if ($ip === '127.0.0.1' || $ip === '::1') {
            return ['country' => 'Local', 'city' => 'Local'];
        }

        try {
            $response = Http::timeout(3)->get("http://ip-api.com/json/{$ip}");
            if ($response->successful()) {
                $data = $response->json();
                return ['country' => $data['country'] ?? null, 'city' => $data['city'] ?? null];
            }
        } catch (\Exception) {}

        return ['country' => null, 'city' => null];
    }

    private function sendEmailNotifications(array $data, string $ip): void
    {
        $ownerEmail = SiteSetting::getValue('contact_email');
        if (!$ownerEmail) {
            return;
        }

        $siteName = SiteSetting::getValue('site_name', config('app.name'));
        $locale   = app()->getLocale();

        $logoSetting = SiteSetting::where('key', 'logo_light')->first();
        $logoUrl = $logoSetting?->value
            ? asset('storage/' . (is_array($logoSetting->value) ? ($logoSetting->value[$locale] ?? reset($logoSetting->value)) : $logoSetting->value))
            : null;

        $shared = [
            'siteName'      => $siteName,
            'logoUrl'       => $logoUrl,
            'senderName'    => $data['name'],
            'senderEmail'   => $data['email'],
            'senderMessage' => $data['message'],
            'ip'            => $ip,
            'locale'        => $locale,
        ];

        // Notify owner
        $ownerSubject = __('New Message') . ' - ' . $data['name'];
        Mail::send(
            'emails.contact-owner',
            array_merge($shared, ['subject' => $ownerSubject]),
            fn($msg) => $msg->from($ownerEmail, $siteName)
                ->to($ownerEmail)
                ->replyTo($data['email'], $data['name'])
                ->subject($ownerSubject)
        );

        // Auto-reply to sender
        $replySubject = __('We received your message') . ' - ' . $siteName;
        Mail::send(
            'emails.contact-autoreply',
            array_merge($shared, ['subject' => $replySubject]),
            fn($msg) => $msg->from($ownerEmail, $siteName)
                ->to($data['email'], $data['name'])
                ->subject($replySubject)
        );
    }

    public function listLeads()
    {
        return Lead::latest()->get();
    }

    public function deleteLead(int $id): bool
    {
        return (bool) Lead::destroy($id);
    }

    public function markAsRead(int $id): bool
    {
        $lead = Lead::find($id);
        if (!$lead) return false;
        
        return $lead->update(['status' => 'read']);
    }

    public function sendReply(int $id, string $replyMessage, array $attachments = []): bool
    {
        $lead = Lead::find($id);
        if (!$lead) return false;

        $mailer     = SiteSetting::getValue('mail_mailer', 'smtp');
        $host       = SiteSetting::getValue('mail_host', config('mail.mailers.smtp.host'));
        $port       = SiteSetting::getValue('mail_port', config('mail.mailers.smtp.port'));
        $username   = SiteSetting::getValue('mail_username', config('mail.mailers.smtp.username'));
        $password   = SiteSetting::getValue('mail_password', config('mail.mailers.smtp.password'));
        $encryption = SiteSetting::getValue('mail_encryption', 'tls');
        $fromAddress = SiteSetting::getValue('mail_from_address', config('mail.from.address'));
        $fromName    = SiteSetting::getValue('mail_from_name', config('mail.from.name'));

        if ($mailer === 'gmail') {
            $host       = 'smtp.gmail.com';
            $port       = 587;
            $encryption = 'tls';
        }

        config([
            'mail.default'                      => 'smtp',
            'mail.mailers.smtp.host'            => $host,
            'mail.mailers.smtp.port'            => $port,
            'mail.mailers.smtp.username'        => $username,
            'mail.mailers.smtp.password'        => $password,
            'mail.mailers.smtp.encryption'      => $encryption,
            'mail.from.address'                 => $fromAddress,
            'mail.from.name'                    => $fromName,
        ]);

        Mail::raw($replyMessage, function ($message) use ($lead, $fromAddress, $fromName, $attachments) {
            $message->from($fromAddress, $fromName)
                ->to($lead->email, $lead->name)
                ->subject(__('Reply to your message: ') . $lead->subject);

            foreach ($attachments as $file) {
                $message->attach($file->getRealPath(), [
                    'as'   => $file->getClientOriginalName(),
                    'mime' => $file->getMimeType(),
                ]);
            }
        });

        $lead->update(['status' => 'replied']);
        return true;
    }
}
