<?php

namespace App\Http\Controllers\Web\Admin\Settings;

use Livewire\Component;
use App\Services\SettingService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Index extends Component
{
    use \Livewire\WithFileUploads;

    public array $settings = [];

    // General Settings
    public string $site_name_ar = '';
    public string $site_name_en = '';
    public string $job_title_ar = '';
    public string $job_title_en = '';
    public string $site_description_ar = '';
    public string $site_description_en = '';
    public string $hero_subtitle_ar = '';
    public string $hero_subtitle_en = '';
    public string $privacy_policy_ar = '';
    public string $privacy_policy_en = '';
    public string $terms_of_service_ar = '';
    public string $terms_of_service_en = '';

    // Identity
    public $logo_light = null;
    public $logo_dark = null;
    public $favicon = null;
    public $hero_image = null;
    public string $existing_logo_light = '';
    public string $existing_logo_dark = '';
    public string $existing_favicon = '';
    public string $existing_hero_image = '';

    // SEO
    public string $seo_title_ar = '';
    public string $seo_title_en = '';
    public string $seo_description_ar = '';
    public string $seo_description_en = '';
    public string $seo_keywords_ar = '';
    public string $seo_keywords_en = '';
    public $og_image = null;
    public string $existing_og_image = '';

    // Contact Info
    public string $contact_email = '';
    public string $contact_phone = '';

    // Social Links
    public string $whatsapp = '';
    public string $facebook = '';
    public string $twitter = '';
    public string $instagram = '';
    public string $linkedin = '';
    public string $tiktok = '';
    public string $youtube = '';

    // Theme Settings
    public bool $dark_mode_supported = true;
    public string $default_theme = 'light';
    public bool $show_theme_toggle = true;

    // Live Status
    public bool $is_online = true;
    public bool $ssl_active = false;
    public string $last_updated_human = '';

    // SEO Tracking & Scripts
    public string $google_analytics_id = '';
    public string $google_tag_manager_id = '';
    public string $facebook_pixel_id = '';
    public string $custom_header_scripts = '';
    public string $custom_body_scripts = '';
    public string $custom_footer_scripts = '';

    // Mail Settings
    public string $mail_mailer = 'smtp';
    public string $mail_host = '';
    public string $mail_port = '587';
    public string $mail_username = '';
    public string $mail_password = '';
    public string $mail_encryption = 'tls';
    public string $mail_from_address = '';
    public string $mail_from_name = '';

    // Legal Editor
    public string $legal_active_lang = 'ar';

    #[Layout('layouts.admin')]
    #[Title('إعدادات الموقع')]
    public function mount(SettingService $service)
    {
        $this->settings = $service->getSettings();
        $this->checkLiveStatus();

        $this->site_name_ar = $this->settings['site_name']['ar'] ?? '';
        $this->site_name_en = $this->settings['site_name']['en'] ?? '';
        $this->job_title_ar = $this->settings['job_title']['ar'] ?? '';
        $this->job_title_en = $this->settings['job_title']['en'] ?? '';
        $this->site_description_ar = $this->settings['site_description']['ar'] ?? '';
        $this->site_description_en = $this->settings['site_description']['en'] ?? '';
        $this->hero_subtitle_ar = $this->settings['hero_subtitle']['ar'] ?? '';
        $this->hero_subtitle_en = $this->settings['hero_subtitle']['en'] ?? '';
        $this->privacy_policy_ar = $this->settings['privacy_policy']['ar'] ?? '';
        $this->privacy_policy_en = $this->settings['privacy_policy']['en'] ?? '';
        $this->terms_of_service_ar = $this->settings['terms_of_service']['ar'] ?? '';
        $this->terms_of_service_en = $this->settings['terms_of_service']['en'] ?? '';
        $this->contact_email = $this->settings['contact_email'] ?? '';
        $this->contact_phone = $this->settings['contact_phone'] ?? '';
        $this->whatsapp = $this->settings['whatsapp'] ?? '';
        $this->facebook = $this->settings['facebook'] ?? '';
        $this->twitter = $this->settings['twitter'] ?? '';
        $this->instagram = $this->settings['instagram'] ?? '';
        $this->linkedin = $this->settings['linkedin'] ?? '';
        $this->tiktok = $this->settings['tiktok'] ?? '';
        $this->youtube = $this->settings['youtube'] ?? '';

        // Identity
        $this->existing_logo_light = $this->settings['logo_light'] ?? '';
        $this->existing_logo_dark = $this->settings['logo_dark'] ?? '';
        $this->existing_favicon = $this->settings['favicon'] ?? '';
        $this->existing_og_image = $this->settings['og_image'] ?? '';
        $this->existing_hero_image = $this->settings['hero_image'] ?? '';

        // SEO
        $this->seo_title_ar = $this->settings['seo_title']['ar'] ?? '';
        $this->seo_title_en = $this->settings['seo_title']['en'] ?? '';
        $this->seo_description_ar = $this->settings['seo_description']['ar'] ?? '';
        $this->seo_description_en = $this->settings['seo_description']['en'] ?? '';
        $this->seo_keywords_ar = $this->settings['seo_keywords']['ar'] ?? '';
        $this->seo_keywords_en = $this->settings['seo_keywords']['en'] ?? '';

        // Theme Settings
        $this->dark_mode_supported = (bool) ($this->settings['dark_mode_supported'] ?? true);
        $this->default_theme = $this->settings['default_theme'] ?? 'light';
        $this->show_theme_toggle = (bool) ($this->settings['show_theme_toggle'] ?? true);

        // SEO Tracking & Scripts
        $this->google_analytics_id = $this->settings['google_analytics_id'] ?? '';
        $this->google_tag_manager_id = $this->google_tag_manager_id ?? '';
        $this->facebook_pixel_id = $this->settings['facebook_pixel_id'] ?? '';
        $this->custom_header_scripts = $this->settings['custom_header_scripts'] ?? '';
        $this->custom_body_scripts = $this->settings['custom_body_scripts'] ?? '';
        $this->custom_footer_scripts = $this->settings['custom_footer_scripts'] ?? '';

        // Mail Settings
        $this->mail_mailer      = $this->settings['mail_mailer'] ?? 'smtp';
        $this->mail_host        = $this->settings['mail_host'] ?? '';
        $this->mail_port        = $this->settings['mail_port'] ?? '587';
        $this->mail_username    = $this->settings['mail_username'] ?? '';
        $this->mail_password    = $this->settings['mail_password'] ?? '';
        $this->mail_encryption  = $this->settings['mail_encryption'] ?? 'tls';
        $this->mail_from_address = $this->settings['mail_from_address'] ?? '';
        $this->mail_from_name   = $this->settings['mail_from_name'] ?? '';
        
    }

    public function save(SettingService $service)
    {
        $data = [
            'site_name' => [
                'ar' => $this->site_name_ar,
                'en' => $this->site_name_en,
            ],
            'job_title' => [
                'ar' => $this->job_title_ar,
                'en' => $this->job_title_en,
            ],
            'site_description' => [
                'ar' => $this->site_description_ar,
                'en' => $this->site_description_en,
            ],
            'hero_subtitle' => [
                'ar' => $this->hero_subtitle_ar,
                'en' => $this->hero_subtitle_en,
            ],
            'privacy_policy' => [
                'ar' => $this->privacy_policy_ar,
                'en' => $this->privacy_policy_en,
            ],
            'terms_of_service' => [
                'ar' => $this->terms_of_service_ar,
                'en' => $this->terms_of_service_en,
            ],
            'contact_email' => $this->contact_email,
            'contact_phone' => $this->contact_phone,
            'whatsapp' => $this->whatsapp,
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'instagram' => $this->instagram,
            'linkedin' => $this->linkedin,
            'tiktok' => $this->tiktok,
            'youtube' => $this->youtube,
            'seo_title' => [
                'ar' => $this->seo_title_ar,
                'en' => $this->seo_title_en,
            ],
            'seo_description' => [
                'ar' => $this->seo_description_ar,
                'en' => $this->seo_description_en,
            ],
            'seo_keywords' => [
                'ar' => $this->seo_keywords_ar,
                'en' => $this->seo_keywords_en,
            ],
            'dark_mode_supported' => $this->dark_mode_supported,
            'default_theme' => $this->default_theme,
            'show_theme_toggle' => $this->show_theme_toggle,
            'google_analytics_id' => $this->google_analytics_id,
            'google_tag_manager_id' => $this->google_tag_manager_id,
            'facebook_pixel_id' => $this->facebook_pixel_id,
            'custom_header_scripts' => $this->custom_header_scripts,
            'custom_body_scripts' => $this->custom_body_scripts,
            'custom_footer_scripts' => $this->custom_footer_scripts,
            'mail_mailer'       => $this->mail_mailer,
            'mail_host'         => $this->mail_host,
            'mail_port'         => $this->mail_port,
            'mail_username'     => $this->mail_username,
            'mail_password'     => $this->mail_password,
            'mail_encryption'   => $this->mail_encryption,
            'mail_from_address' => $this->mail_from_address,
            'mail_from_name'    => $this->mail_from_name,
        ];

        // Handle file uploads
        if ($this->logo_light) {
            $data['logo_light'] = $this->logo_light->store('identity', 'public');
        }
        if ($this->logo_dark) {
            $data['logo_dark'] = $this->logo_dark->store('identity', 'public');
        }
        if ($this->favicon) {
            $data['favicon'] = $this->favicon->store('identity', 'public');
        }
        if ($this->og_image) {
            $data['og_image'] = $this->og_image->store('identity', 'public');
        }
        if ($this->hero_image) {
            $data['hero_image'] = $this->hero_image->store('hero', 'public');
        }

        // Save settings via service
        $service->updateSettings($data);

        // Reset upload properties
        $this->logo_light = null;
        $this->logo_dark = null;
        $this->favicon = null;
        $this->og_image = null;
        $this->hero_image = null;

        // Refresh existing values & status
        $this->mount($service);

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => __('Settings saved successfully')
        ]);
    }

    private function checkLiveStatus()
    {
        // 1. Site Status
        $this->is_online = true;

        // 2. SSL Status
        $this->ssl_active = request()->secure() || (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on');

        // 3. Last Updated
        $lastSetting = \App\Models\SiteSetting::latest('updated_at')->first();
        $this->last_updated_human = $lastSetting ? $lastSetting->updated_at->diffForHumans() : __('Never');
    }

    public function render()
    {
        return view('livewire.admin.settings.index')
            ->title(__('Manage Settings'));
    }
}