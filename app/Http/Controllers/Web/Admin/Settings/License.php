<?php

namespace App\Http\Controllers\Web\Admin\Settings;

use App\Services\LicenseService;
use App\Services\LicenseStateService;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class License extends Component
{
    public $license_key = '';
    public $status = [];
    public $is_loading = false;

    public function mount(LicenseStateService $stateService)
    {
        $this->status = $stateService->getStatusDetails();
        $this->license_key = $this->status['key'] !== 'None' ? $this->status['key'] : '';
    }

    public function activate(LicenseService $licenseService, LicenseStateService $stateService)
    {
        $this->validate([
            'license_key' => 'required|string',
        ]);

        $this->is_loading = true;

        $result = $licenseService->verify($this->license_key);

        $this->is_loading = false;

        if ($result['success']) {
            $this->dispatch('notify', ['type' => 'success', 'message' => __('Product activated successfully!')]);
        } else {
            $this->dispatch('notify', ['type' => 'error', 'message' => $result['error']]);
        }

        $this->status = $stateService->getStatusDetails();
    }
    public function refresh(LicenseService $licenseService, LicenseStateService $stateService)
    {
        if ($this->status['key'] === 'None') return;

        $this->is_loading = true;
        $result = $licenseService->verify($this->status['key']);
        $this->is_loading = false;

        if ($result['success']) {
            $this->dispatch('notify', ['type' => 'success', 'message' => __('License refreshed successfully!')]);
        } else {
            $this->dispatch('notify', ['type' => 'error', 'message' => $result['error']]);
        }

        $this->status = $stateService->getStatusDetails();
    }

    #[Layout('layouts.admin')]
    #[Title('License Activation')]
    public function render()
    {
        return view('livewire.admin.settings.license');
    }
}
