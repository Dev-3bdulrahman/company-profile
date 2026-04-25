<?php

namespace App\Http\Controllers\Web;

use App\Services\Internal\ContactService;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Contact extends Component
{
    public $name, $email, $message;
    public bool $contactSent = false;

    protected $contactService;

    public function boot(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.contact');
    }

    public function sendMessage()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|min:10',
        ]);

        $this->contactService->handleContactMessage([
            'name' => $this->name,
            'email' => $this->email,
            'message' => $this->message,
        ], request()->ip());

        $this->contactSent = true;
        $this->reset(['name', 'email', 'message']);
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => __('Your message has been sent successfully!')
        ]);
    }
}
