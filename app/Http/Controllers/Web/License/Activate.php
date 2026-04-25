<?php

namespace App\Http\Controllers\Web\License;

use App\Services\LicenseService;
use App\Services\LicenseStateService;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Activate extends Component
{
    public $license_key = '';
    public $is_loading = false;
    public $error_message = '';
    public $success_message = '';

    public function activate(LicenseService $licenseService, LicenseStateService $stateService)
    {
        $this->validate([
            'license_key' => 'required|string',
        ]);

        \Illuminate\Support\Facades\Log::info("Activation attempt with key: " . $this->license_key);
        $this->is_loading = true;
        $this->error_message = '';
        $this->success_message = '';

        $result = $licenseService->verify($this->license_key);

        $this->is_loading = false;

        if ($result['success']) {
            $this->success_message = __('Product activated successfully! Redirecting...');
            $this->dispatch('license-activated');
            
            // Redirect after a small delay
            return redirect()->route('admin.dashboard');
        } else {
            $this->error_message = $result['error'];
        }
    }

    #[Layout('layouts.license')]
    #[Title('Activate Product')]
    public function render()
    {
        return view('livewire.license.activate');
    }
}
