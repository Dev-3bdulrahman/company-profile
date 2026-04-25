<div class="min-h-screen flex flex-col items-center justify-center py-16 px-4" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    {{-- Header --}}
    <div class="w-full max-w-2xl flex justify-between items-start mb-10 animate-fade-up">
        <div class="text-start">
            <div class="inline-flex items-center gap-2 glass rounded-full px-4 py-2 mb-6">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-xs font-semibold text-white/60 uppercase tracking-widest">{{ __('Setup Wizard') }}</span>
            </div>
            <h1 class="text-4xl sm:text-5xl font-black text-white tracking-tight leading-tight">
                {{ config('app.name') }}
            </h1>
            <p class="mt-3 text-white/40 font-medium">{{ __('Complete the steps below to get started.') }}</p>
        </div>

        {{-- Language Switcher --}}
        <div class="flex gap-2 p-1 glass rounded-2xl">
            <button wire:click="setLocale('ar')" @class(['px-4 py-2 rounded-xl text-xs font-bold transition-all', 'bg-white/10 text-white shadow-xl' => app()->getLocale() == 'ar', 'text-white/40 hover:text-white' => app()->getLocale() != 'ar'])>
                عربي
            </button>
            <button wire:click="setLocale('en')" @class(['px-4 py-2 rounded-xl text-xs font-bold transition-all', 'bg-white/10 text-white shadow-xl' => app()->getLocale() == 'en', 'text-white/40 hover:text-white' => app()->getLocale() != 'en'])>
                EN
            </button>
        </div>
    </div>

    {{-- Stepper --}}
    <div class="flex items-center gap-0 mb-10 animate-fade-up" style="animation-delay:.1s">
        @php
            $stepLabels = [1 => __('Requirements'), 2 => __('License'), 3 => __('Database'), 4 => __('Admin Account'), 5 => __('Done')];
            $stepIcons  = [1 => 'server', 2 => 'shield-check', 3 => 'database', 4 => 'user-plus', 5 => 'party-popper'];
        @endphp
        @foreach([1,2,3,4,5] as $s)
            <div class="flex flex-col items-center">
                <div @class([
                    'w-11 h-11 rounded-2xl flex items-center justify-center font-bold text-sm transition-all duration-300',
                    'step-active text-white pulse-ring' => $step == $s,
                    'step-done text-white' => $step > $s,
                    'step-idle text-white/30' => $step < $s,
                ])>
                    @if($step > $s)
                        <i data-lucide="check" class="w-5 h-5"></i>
                    @else
                        <i data-lucide="{{ $stepIcons[$s] }}" class="w-5 h-5"></i>
                    @endif
                </div>
                <span @class([
                    'mt-2 text-[10px] font-bold uppercase tracking-wider transition-colors',
                    'text-indigo-400' => $step == $s,
                    'text-emerald-400' => $step > $s,
                    'text-white/20' => $step < $s,
                ])>{{ $stepLabels[$s] }}</span>
            </div>
            @if($s < 5)
                <div @class([
                    'h-px w-8 sm:w-16 mb-5 transition-all duration-500',
                    'connector-done' => $step > $s,
                    'connector-idle' => $step <= $s,
                ])></div>
            @endif
        @endforeach
    </div>

    {{-- Card --}}
    <div class="w-full max-w-xl glass-card rounded-3xl overflow-hidden animate-fade-up" style="animation-delay:.2s">

        {{-- Card top accent --}}
        <div class="h-1 w-full" style="background: linear-gradient(90deg, #6366f1, #8b5cf6, #06b6d4)"></div>

        <div class="p-8 sm:p-10">

            {{-- ── STEP 1: Requirements ── --}}
            @if($step == 1)
            <div class="space-y-7 animate-fade-up">
                <div>
                    <h2 class="text-xl font-black text-white flex items-center gap-2 mb-4">
                        <i data-lucide="server" class="w-5 h-5 text-indigo-400"></i>
                        {{ __('System Requirements') }}
                    </h2>
                    <div class="space-y-2">
                        @foreach($requirements as $req)
                        <div class="req-row flex items-center justify-between px-4 py-3 rounded-xl">
                            <span class="text-sm font-semibold text-white/80">{{ __($req['name']) }}</span>
                            <div class="flex items-center gap-3">
                                @if(isset($req['current']))
                                    <span class="text-[10px] font-mono text-white/30">{{ $req['current'] }}</span>
                                @endif
                                <span @class(['text-[10px] font-bold px-2 py-0.5 rounded-full', 'badge-pass' => $req['passed'], 'badge-fail' => !$req['passed']])>
                                    {{ $req['passed'] ? __('OK') : __('FAIL') }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-black text-white flex items-center gap-2 mb-4">
                        <i data-lucide="folder-lock" class="w-5 h-5 text-indigo-400"></i>
                        {{ __('Folder Permissions') }}
                    </h2>
                    <div class="space-y-2">
                        @foreach($permissions as $perm)
                        <div class="req-row flex items-center justify-between px-4 py-3 rounded-xl">
                            <div>
                                <p class="text-sm font-semibold text-white/80">{{ __($perm['name']) }}</p>
                                <p class="text-[10px] font-mono text-white/25 mt-0.5">{{ $perm['path'] }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                @if(isset($perm['note']) && $perm['note'])
                                    <span class="text-[10px] font-bold text-indigo-400/60 uppercase">{{ $perm['note'] }}</span>
                                @endif
                                <span @class(['text-[10px] font-bold px-2 py-0.5 rounded-full', 'badge-pass' => $perm['passed'], 'badge-fail' => !$perm['passed']])>
                                    {{ $perm['passed'] ? __('OK') : __('FAIL') }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <button wire:click="nextStep" @disabled(!$canContinueRequirements) @class([
                    'w-full py-4 rounded-2xl font-black text-base flex items-center justify-center gap-3 transition-all mt-8',
                    'btn-primary text-white' => $canContinueRequirements,
                    'bg-white/5 text-white/20 cursor-not-allowed border border-white/10' => !$canContinueRequirements,
                ])>
                    {{ __('Continue') }}
                    <i data-lucide="arrow-right" class="w-4 h-4 shrink-0"></i>
                </button>
            </div>

            {{-- ── STEP 2: License ── --}}
            @elseif($step == 2)
            <div class="space-y-7 animate-fade-up">
                <div class="text-center">
                    <div class="w-16 h-16 rounded-2xl mx-auto flex items-center justify-center mb-5 pulse-ring" style="background: linear-gradient(135deg,#6366f1,#8b5cf6)">
                        <i data-lucide="shield-check" class="w-8 h-8 text-white"></i>
                    </div>
                    <h2 class="text-2xl font-black text-white">{{ __('Activate License') }}</h2>
                    <p class="text-white/40 text-sm mt-1">{{ __('Enter your license key to verify your purchase.') }}</p>
                </div>

                <div class="space-y-4">
                    <div class="relative">
                        <label class="label-text mb-2 block">{{ __('License Key') }}</label>
                        <div class="absolute inset-y-0 left-4 flex items-center text-white/30 pointer-events-none mt-6">
                            <i data-lucide="key" class="w-5 h-5"></i>
                        </div>
                        <input type="text" wire:model="license_key"
                            placeholder="XXXX-XXXX-XXXX-XXXX"
                            class="input-field w-full pl-12 pr-5 py-4 rounded-2xl font-mono text-lg tracking-widest uppercase"
                            style="color:#fff !important">
                    </div>

                    <div class="relative">
                        <label class="label-text mb-2 block">{{ __('Product Code') }}</label>
                        <div class="absolute inset-y-0 left-4 flex items-center text-white/30 pointer-events-none mt-6">
                            <i data-lucide="package" class="w-5 h-5"></i>
                        </div>
                        <input type="text" wire:model="product_code"
                            placeholder="PROD-XXXXXX"
                            class="input-field w-full pl-12 pr-5 py-4 rounded-2xl font-mono text-sm tracking-wider uppercase"
                            style="color:#fff !important">
                    </div>
                    @if($licenseError)
                    <div class="flex items-center gap-3 px-4 py-3 rounded-xl" style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.2)">
                        <i data-lucide="alert-circle" class="w-4 h-4 text-red-400 shrink-0"></i>
                        <span class="text-sm text-red-400 font-semibold">{{ $licenseError }}</span>
                    </div>
                    @endif
                </div>

                <button wire:click="nextStep" wire:loading.attr="disabled"
                    class="btn-primary w-full py-4 rounded-2xl font-black text-base text-white flex items-center justify-center gap-3 mt-8">
                    <span wire:loading.remove wire:target="nextStep" class="flex items-center gap-3">{{ __('Verify & Continue') }}<i data-lucide="arrow-right" class="w-4 h-4 shrink-0"></i></span>
                    <span wire:loading wire:target="nextStep" class="flex items-center gap-3">
                        <i data-lucide="loader-2" class="w-4 h-4 shrink-0 animate-spin"></i>
                        {{ __('Verifying...') }}
                    </span>
                </button>
            </div>

            {{-- ── STEP 3: Database ── --}}
            @elseif($step == 3)
            <div class="space-y-7 animate-fade-up">
                <div class="text-center">
                    <div class="w-16 h-16 rounded-2xl mx-auto flex items-center justify-center mb-5" style="background: linear-gradient(135deg,#10b981,#059669);box-shadow:0 8px 32px rgba(16,185,129,.4)">
                        <i data-lucide="database" class="w-8 h-8 text-white"></i>
                    </div>
                    <h2 class="text-2xl font-black text-white">{{ __('Database Setup') }}</h2>
                    <p class="text-white/40 text-sm mt-1">{{ __('Configure your database connection.') }}</p>
                </div>

                @if($dbError)
                <div class="flex items-start gap-3 px-4 py-3 rounded-xl" style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.2)">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-red-400 shrink-0 mt-0.5"></i>
                    <span class="text-sm text-red-400 font-semibold">{{ $dbError }}</span>
                </div>
                @endif

                @if($showDbPrompt)
                <div class="space-y-6 py-4 animate-fade-up">
                    <div class="p-6 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-center">
                        <div class="w-12 h-12 rounded-xl bg-amber-500/20 flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="alert-triangle" class="w-6 h-6 text-amber-500"></i>
                        </div>
                        <h3 class="text-lg font-black text-white mb-2">{{ __('Existing Tables Found') }}</h3>
                        <p class="text-white/40 text-sm leading-relaxed">
                            {{ __('The database already contains tables. What would you like to do?') }}
                        </p>
                    </div>

                    <div class="grid gap-3">
                        <button wire:click="startFreshInstall" 
                            class="w-full py-4 rounded-2xl font-black text-sm text-white flex items-center justify-center gap-3 transition-all bg-red-500/10 border border-red-500/20 hover:bg-red-500/20">
                            <i data-lucide="refresh-cw" class="w-4 h-4 text-red-500"></i>
                            {{ __('Fresh Install (Delete All)') }}
                        </button>
                        
                        <button wire:click="keepDataUpdateAdmin" 
                            class="w-full py-4 rounded-2xl font-black text-sm text-white flex items-center justify-center gap-3 transition-all bg-indigo-500/10 border border-indigo-500/20 hover:bg-indigo-500/20">
                            <i data-lucide="user-cog" class="w-4 h-4 text-indigo-500"></i>
                            {{ __('Keep Data & Update Admin') }}
                        </button>

                        <button wire:click="skipToFinish" 
                            class="w-full py-4 rounded-2xl font-black text-sm text-white/40 flex items-center justify-center gap-3 transition-all bg-white/5 border border-white/10 hover:text-white hover:bg-white/10">
                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                            {{ __('Finish (No Changes)') }}
                        </button>
                    </div>
                </div>
                @elseif($isInstalling)
                <div class="space-y-4 py-6 animate-fade-up">
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm font-bold text-white/60 uppercase tracking-widest">{{ $installStatus }}</span>
                        <span class="text-sm font-black text-indigo-400">{{ $installProgress }}%</span>
                    </div>
                    <div class="w-full h-3 bg-white/5 rounded-full overflow-hidden p-0.5 border border-white/10">
                        <div class="h-full bg-gradient-to-r from-indigo-500 to-fuchsia-500 rounded-full transition-all duration-700 ease-out shadow-[0_0_15px_rgba(99,102,241,0.5)]" 
                             style="width: {{ $installProgress }}%"></div>
                    </div>
                    <div class="flex items-center gap-3 justify-center text-white/30 text-xs font-medium">
                        <i data-lucide="loader-2" class="w-3.5 h-3.5 animate-spin"></i>
                        <span>{{ __('Please do not close this page...') }}</span>
                    </div>
                </div>
                @else
                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="label-text">{{ __('Host') }}</label>
                        <input type="text" wire:model="dbConfig.host"
                            class="input-field w-full px-4 py-3.5 rounded-xl text-sm font-medium">
                    </div>
                    <div class="space-y-1.5">
                        <label class="label-text">{{ __('Port') }}</label>
                        <input type="text" wire:model="dbConfig.port"
                            class="input-field w-full px-4 py-3.5 rounded-xl text-sm font-medium">
                    </div>
                    <div class="space-y-1.5">
                        <label class="label-text">{{ __('Database Name') }}</label>
                        <input type="text" wire:model="dbConfig.database"
                            class="input-field w-full px-4 py-3.5 rounded-xl text-sm font-medium">
                    </div>
                    <div class="space-y-1.5">
                        <label class="label-text">{{ __('Username') }}</label>
                        <input type="text" wire:model="dbConfig.username"
                            class="input-field w-full px-4 py-3.5 rounded-xl text-sm font-medium">
                    </div>
                    <div class="sm:col-span-2 space-y-1.5">
                        <label class="label-text">{{ __('Password') }}</label>
                        <input type="password" wire:model="dbConfig.password"
                            class="input-field w-full px-4 py-3.5 rounded-xl text-sm font-medium">
                    </div>
                </div>

                <button wire:click="setupDatabase" wire:loading.attr="disabled"
                    class="btn-success w-full py-4 rounded-2xl font-black text-base text-white flex items-center justify-center gap-2 mt-6">
                    <span wire:loading.remove>{{ __('Install Now') }}</span>
                    <span wire:loading class="flex items-center gap-2">
                        <i data-lucide="loader-2" class="w-5 h-5 animate-spin"></i>
                        {{ __('Connecting...') }}
                    </span>
                    <i data-lucide="zap" class="w-4 h-4" wire:loading.remove></i>
                </button>
                @endif
            </div>

            {{-- ── STEP 4: Admin Account ── --}}
            @elseif($step == 4)
            <div class="space-y-7 animate-fade-up">
                <div class="text-center">
                    <div class="w-16 h-16 rounded-2xl mx-auto flex items-center justify-center mb-5" style="background: linear-gradient(135deg,#8b5cf6,#d946ef);box-shadow:0 8px 32px rgba(139,92,246,.4)">
                        <i data-lucide="user-plus" class="w-8 h-8 text-white"></i>
                    </div>
                    <h2 class="text-2xl font-black text-white">{{ __('Admin Account') }}</h2>
                    <p class="text-white/40 text-sm mt-1">{{ __('Create an administrator account.') }}</p>
                </div>

                @if($adminError)
                <div class="flex items-start gap-3 px-4 py-3 rounded-xl" style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.2)">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-red-400 shrink-0 mt-0.5"></i>
                    <span class="text-sm text-red-400 font-semibold">{{ $adminError }}</span>
                </div>
                @endif

                <div class="space-y-4">
                    <div class="space-y-1.5">
                        <label class="label-text">{{ __('Name') }}</label>
                        <input type="text" wire:model="adminConfig.name"
                            class="input-field w-full px-4 py-3.5 rounded-xl text-sm font-medium">
                        @error('adminConfig.name') <span class="text-[10px] text-red-400 font-bold uppercase">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="label-text">{{ __('Email') }}</label>
                        <input type="email" wire:model="adminConfig.email"
                            class="input-field w-full px-4 py-3.5 rounded-xl text-sm font-medium">
                        @error('adminConfig.email') <span class="text-[10px] text-red-400 font-bold uppercase">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="label-text">{{ __('Password') }}</label>
                            <input type="password" wire:model="adminConfig.password"
                                class="input-field w-full px-4 py-3.5 rounded-xl text-sm font-medium">
                            @error('adminConfig.password') <span class="text-[10px] text-red-400 font-bold uppercase">{{ $message }}</span> @enderror
                        </div>
                        <div class="space-y-1.5">
                            <label class="label-text">{{ __('Confirm Password') }}</label>
                            <input type="password" wire:model="adminConfig.password_confirmation"
                                class="input-field w-full px-4 py-3.5 rounded-xl text-sm font-medium">
                        </div>
                    </div>
                </div>

                <button wire:click="nextStep" wire:loading.attr="disabled"
                    class="btn-primary w-full py-4 rounded-2xl font-black text-base text-white flex items-center justify-center gap-2 mt-6">
                    <span wire:loading.remove>{{ __('Create & Finish') }}</span>
                    <span wire:loading class="flex items-center gap-2">
                        <i data-lucide="loader-2" class="w-5 h-5 animate-spin"></i>
                        {{ __('Creating Account...') }}
                    </span>
                    <i data-lucide="check" class="w-4 h-4" wire:loading.remove></i>
                </button>
            </div>

            {{-- ── STEP 5: Done ── --}}
            @elseif($step == 5)
            <div class="text-center space-y-8 animate-fade-up py-4">
                <div class="relative inline-block">
                    <div class="w-24 h-24 rounded-3xl mx-auto flex items-center justify-center text-white" style="background:linear-gradient(135deg,#10b981,#059669);box-shadow:0 16px 48px rgba(16,185,129,.5)">
                        <i data-lucide="check" class="w-12 h-12"></i>
                    </div>
                    <div class="absolute -top-1 -right-1 w-6 h-6 bg-yellow-400 rounded-full flex items-center justify-center">
                        <i data-lucide="star" class="w-3 h-3 text-yellow-900"></i>
                    </div>
                </div>

                <div>
                    <h2 class="text-3xl font-black text-white">{{ __('All Done!') }}</h2>
                    <p class="text-white/40 mt-3 leading-relaxed">
                        {{ __('Your application is installed and ready to use.') }}
                    </p>
                </div>

                <div class="grid gap-3">
                    <a href="{{ route('login') }}"
                        class="btn-primary w-full py-4 rounded-2xl font-black text-base text-white flex items-center justify-center gap-2">
                        {{ __('Go to Login') }}
                        <i data-lucide="log-in" class="w-4 h-4"></i>
                    </a>
                    <a href="{{ url('/') }}"
                        class="w-full py-4 rounded-2xl font-black text-base text-white/60 flex items-center justify-center gap-2 transition-all hover:text-white"
                        style="background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1)">
                        {{ __('View Website') }}
                        <i data-lucide="external-link" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
            @endif

        </div>
    </div>

    {{-- Footer --}}
    <p class="mt-8 text-center text-[10px] text-white/20 font-bold uppercase tracking-widest animate-fade-up" style="animation-delay:.3s">
        &copy; {{ date('Y') }} {{ config('app.name') }} &nbsp;·&nbsp; Installer v2.4
    </p>
</div>
