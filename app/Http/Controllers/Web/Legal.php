<?php

namespace App\Http\Controllers\Web;

use App\Models\SiteSetting;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Legal extends Component
{
    public $type; // 'privacy' or 'terms'
    public $title;
    public $content;

    public function mount()
    {
        $this->type = request()->routeIs('legal.privacy') ? 'privacy' : 'terms';
        
        if ($this->type === 'privacy') {
            $this->title = __('landing.contact.privacy_policy');
            $this->content = SiteSetting::getValue('privacy_policy');
        } else {
            $this->title = __('landing.contact.terms_of_service');
            $this->content = SiteSetting::getValue('terms_of_service');
        }
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.legal');
    }
}
