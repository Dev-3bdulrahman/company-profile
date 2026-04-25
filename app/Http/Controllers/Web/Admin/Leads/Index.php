<?php

namespace App\Http\Controllers\Web\Admin\Leads;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\Internal\ContactService;
use App\Models\SiteSetting;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Mail;

class Index extends Component
{
    use WithFileUploads;

    public array $leads = [];
    public ?array $selectedLead = null;
    public bool $showModal = false;
    public bool $showReplyModal = false;

    // Reply form
    public ?array $replyTarget = null;
    public string $replyMessage = '';
    public $replyAttachments = [];
    public bool $replySent = false;
    public string $replyError = '';

    #[Layout('layouts.admin')]
    public function mount(ContactService $service)
    {
        $this->leads = $service->listLeads()->toArray();
    }

    public function viewLead(int $id)
    {
        $this->selectedLead = collect($this->leads)->firstWhere('id', $id);
        $this->showModal = true;
    }

    public function openReply(int $id)
    {
        $this->replyTarget    = collect($this->leads)->firstWhere('id', $id);
        $this->replyMessage   = '';
        $this->replyAttachments = [];
        $this->replySent      = false;
        $this->replyError     = '';
        $this->showReplyModal = true;
    }

    public function sendReply(ContactService $service)
    {
        $this->validate([
            'replyMessage'      => 'required|string|min:5',
            'replyAttachments.*' => 'nullable|file|max:10240',
        ]);

        try {
            $service->sendReply($this->replyTarget['id'], $this->replyMessage, $this->replyAttachments ?? []);
            
            $this->leads    = $service->listLeads()->toArray();
            $this->replySent = true;

        } catch (\Exception $e) {
            $this->replyError = __('Failed to send email. Please try again.');
        }
    }

    public function delete(ContactService $service, $id)
    {
        $targetId = is_array($id) ? ($id['id'] ?? null) : $id;
        if ($targetId) {
            $service->deleteLead($targetId);
            $this->dispatch('notify', ['type' => 'success', 'message' => __('Message deleted successfully')]);
            $this->leads = $service->listLeads()->toArray();
        }
    }

    public function markAsRead(int $id, ContactService $service)
    {
        $service->markAsRead($id);
        $this->leads = $service->listLeads()->toArray();
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.admin.leads.index')
            ->title(__('Contact Messages'));
    }
}
