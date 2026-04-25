<?php

namespace App\Http\Controllers\Web;

use App\Services\ServiceService;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Services extends Component
{
    public $services;

    #[Layout('layouts.guest')]
    public function mount(ServiceService $ss)
    {
        $this->services = $ss->listServices(['active_only' => true]);
    }

    public function render()
    {
        return view('livewire.services');
    }
}
