<?php

namespace App\Http\Controllers\Web\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    #[Layout('layouts.auth')]
    public function render()
    {
        return view('livewire.auth.login')
            ->title(__('Login'));
    }

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();

            // Refresh license state on login
            try {
                $licenseCache = \App\Models\LicenseCache::latest()->first();
                if ($licenseCache && $licenseCache->license_key) {
                    app(\App\Services\LicenseService::class)->verify($licenseCache->license_key);
                }
            } catch (\Exception $e) {
                // Fail silently if server unreachable during login to avoid blocking user
            }

            $user = Auth::user();

            if ($user->hasRole('super-admin')) {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->hasRole('employee')) {
                return redirect()->intended(route('staff.dashboard'));
            } elseif ($user->hasRole('client')) {
                return redirect()->intended(route('portal.dashboard'));
            }

            return redirect()->intended('/');
        }

        $this->addError('email', __('Invalid credentials.'));
    }
}
