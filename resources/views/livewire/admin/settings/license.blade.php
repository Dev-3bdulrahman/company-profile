<div class="p-6 sm:p-10 space-y-8 animate-in fade-in duration-700" x-data x-init="if(window.initLucide) initLucide()">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-4xl font-black text-gray-900 dark:text-white flex items-center gap-4 tracking-tight">
                <div class="p-3 bg-blue-600 rounded-2xl shadow-xl shadow-blue-600/20 text-white">
                    <i data-lucide="shield-check" class="w-8 h-8"></i>
                </div>
                {{ __('System License') }}
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2 text-lg font-medium">{{ __('Manage your product activation and license details.') }}</p>
        </div>
        
        <div class="flex items-center gap-4">
            @if($status['is_usable'])
                <div class="px-4 py-2 bg-green-500/10 text-green-600 rounded-xl border border-green-500/20 flex items-center gap-2 text-sm font-black uppercase tracking-widest">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                    </span>
                    {{ __('Verified') }}
                </div>
            @endif
            <button wire:click="refresh" wire:loading.attr="disabled"
                class="p-3 bg-white dark:bg-gray-900 text-gray-500 dark:text-gray-400 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-md transition-all group">
                <i data-lucide="refresh-cw" class="w-5 h-5 group-hover:rotate-180 transition-transform duration-500" wire:loading.class="animate-spin" wire:target="refresh"></i>
            </button>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        {{-- Left: Activation & Info --}}
        <div class="lg:col-span-2 space-y-8">
            {{-- License Input Card --}}
            <div class="relative overflow-hidden bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-sm border border-gray-100 dark:border-gray-800 p-8 sm:p-12">
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-blue-600/5 rounded-full blur-3xl"></div>
                
                <form wire:submit="activate" class="relative space-y-8">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-4">{{ __('Activation Key') }}</label>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="flex-1 relative group">
                                <div class="absolute inset-y-0 left-6 flex items-center text-gray-400 group-focus-within:text-blue-600 transition-colors">
                                    <i data-lucide="key" class="w-5 h-5"></i>
                                </div>
                                <input type="text" wire:model="license_key" 
                                    placeholder="XXXX-XXXX-XXXX-XXXX"
                                    class="w-full pl-16 pr-6 py-5 bg-gray-50 dark:bg-gray-800 border-transparent rounded-[1.5rem] focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-mono text-xl tracking-wider placeholder:text-gray-300 dark:placeholder:text-gray-600">
                            </div>
                            <button type="submit" wire:loading.attr="disabled"
                                class="px-10 py-5 bg-blue-600 text-white rounded-[1.5rem] font-black text-lg hover:bg-blue-700 shadow-2xl shadow-blue-600/30 hover:shadow-blue-600/50 transition-all flex items-center justify-center gap-3 active:scale-95">
                                <span wire:loading.remove wire:target="activate">{{ __('Activate') }}</span>
                                <span wire:loading wire:target="activate" class="flex items-center gap-2">
                                    <i data-lucide="loader-2" class="w-6 h-6 animate-spin"></i>
                                    {{ __('Processing...') }}
                                </span>
                            </button>
                        </div>
                        @error('license_key') <p class="text-red-500 text-xs mt-3 font-bold flex items-center gap-1"><i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}</p> @enderror
                    </div>
                </form>

                {{-- Status Info --}}
                <div class="mt-12 grid md:grid-cols-2 gap-6">
                    <div class="p-6 bg-gray-50 dark:bg-gray-800/50 rounded-3xl border border-gray-100 dark:border-gray-800">
                        <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3">{{ __('Installation ID') }}</p>
                        <div class="flex items-center justify-between gap-3">
                            <code class="text-xs font-mono text-gray-600 dark:text-gray-400 truncate">
                                {{ md5(php_uname() . php_sapi_name() . (isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : 'local')) }}
                            </code>
                            <button x-on:click="navigator.clipboard.writeText('{{ md5(php_uname() . php_sapi_name() . (isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : 'local')) }}')" 
                                class="text-blue-600 hover:text-blue-700 font-bold text-[10px] uppercase">{{ __('Copy') }}</button>
                        </div>
                    </div>
                    <div class="p-6 bg-gray-50 dark:bg-gray-800/50 rounded-3xl border border-gray-100 dark:border-gray-800">
                        <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3">{{ __('Registered Domain') }}</p>
                        <div class="flex items-center gap-2">
                            <i data-lucide="globe" class="w-4 h-4 text-gray-400"></i>
                            <span class="text-sm font-black text-gray-900 dark:text-white">{{ request()->getHost() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Support & Resources --}}
            <div class="bg-gray-900 dark:bg-black rounded-[2.5rem] p-10 text-white relative overflow-hidden group shadow-2xl">
                <div class="absolute top-0 right-0 w-64 h-64 bg-blue-600/10 rounded-full blur-[100px] group-hover:scale-150 transition-transform duration-1000"></div>
                <div class="relative flex flex-col md:flex-row items-center gap-10">
                    <div class="shrink-0">
                        <div class="w-24 h-24 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl flex items-center justify-center shadow-2xl rotate-3 group-hover:rotate-6 transition-transform">
                            <i data-lucide="help-circle" class="w-12 h-12"></i>
                        </div>
                    </div>
                    <div class="flex-1 text-center md:text-left">
                        <h3 class="text-2xl font-black mb-3">{{ __('Activation Troubleshooting') }}</h3>
                        <p class="text-gray-400 text-lg leading-relaxed mb-6">
                            {{ __('If you encounter any issues with your activation key or if you\'ve reached your installation limit, our technical support team is ready to assist you.') }}
                        </p>
                        <div class="flex flex-wrap justify-center md:justify-start gap-4">
                            <a href="mailto:support@3bdulrahman.com" class="px-6 py-3 bg-white text-black rounded-xl font-bold text-sm hover:bg-gray-100 transition-all flex items-center gap-2">
                                <i data-lucide="mail" class="w-4 h-4"></i>
                                {{ __('Contact Support') }}
                            </a>
                            <a href="https://3bdulrahman.com" target="_blank" class="px-6 py-3 bg-white/10 text-white rounded-xl font-bold text-sm hover:bg-white/20 transition-all flex items-center gap-2 border border-white/10 backdrop-blur-md">
                                <i data-lucide="external-link" class="w-4 h-4"></i>
                                {{ __('Client Dashboard') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Status Summary --}}
        <div class="space-y-8">
            <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
                <div class="p-8 border-b border-gray-50 dark:border-gray-800 bg-gray-50/30 dark:bg-gray-800/30">
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">{{ __('Live Status') }}</h3>
                </div>
                
                <div class="p-10 text-center">
                    <div @class([
                        'w-28 h-28 rounded-[2rem] mx-auto mb-6 flex items-center justify-center shadow-2xl transition-all duration-500 scale-105',
                        'bg-gradient-to-br from-green-500 to-emerald-600 text-white shadow-green-500/30' => $status['is_usable'],
                        'bg-gradient-to-br from-red-500 to-rose-600 text-white shadow-red-500/30' => !$status['is_usable'],
                    ])>
                        <i data-lucide="{{ $status['is_usable'] ? 'check-circle' : 'alert-octagon' }}" class="w-14 h-14"></i>
                    </div>
                    <h2 @class([
                        'text-3xl font-black uppercase tracking-tighter',
                        'text-green-600' => $status['is_usable'],
                        'text-red-600' => !$status['is_usable'],
                    ])>{{ __($status['status']) }}</h2>
                    <p class="text-sm font-medium text-gray-500 mt-3 leading-relaxed px-4">
                        @if($status['is_usable'])
                            @if($status['is_in_local_grace'])
                                <span class="text-orange-600 font-bold block mb-1">⚠️ {{ __('Connectivity Alert') }}</span>
                                {{ __('System could not reach the license server. You are currently in a grace period. Please check your internet connection.') }}
                            @else
                                {{ __('Your system is fully licensed and protected. All professional features are unlocked.') }}
                            @endif
                        @else
                            {{ __('The system is currently locked. Please enter a valid license key to regain access.') }}
                        @endif
                    </p>

                </div>

                <div class="px-10 pb-10 space-y-5">
                    <div class="flex items-center justify-between text-sm py-4 border-t border-gray-50 dark:border-gray-800">
                        <span class="text-gray-500 font-medium">{{ __('Last Pulse Check') }}</span>
                        <span class="font-black text-gray-900 dark:text-white">
                            {{ $status['last_verified_at'] ? $status['last_verified_at']->diffForHumans() : __('Never') }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-sm py-4 border-t border-gray-50 dark:border-gray-800">
                        <span class="text-gray-500 font-medium">{{ __('Plan Expiration') }}</span>
                        <span class="font-black text-gray-900 dark:text-white">
                            {{ $status['expires_at'] ? $status['expires_at']->format('M d, Y') : __('Lifetime Access') }}
                        </span>
                    </div>
                    @if($status['key'] !== 'None')
                    <div class="pt-4">
                        <button wire:click="refresh" wire:loading.attr="disabled"
                            class="w-full py-4 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-gray-100 dark:hover:bg-gray-700 transition-all flex items-center justify-center gap-3 border border-gray-100 dark:border-gray-700">
                            <i data-lucide="refresh-cw" class="w-3 h-3" wire:loading.class="animate-spin" wire:target="refresh"></i>
                            {{ __('Synchronize License') }}
                        </button>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Trust Badge --}}
            <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-[2.5rem] p-8 text-white text-center shadow-xl">
                <i data-lucide="award" class="w-10 h-10 mx-auto mb-4 opacity-50"></i>
                <h4 class="text-lg font-black">{{ __('Genuine Software') }}</h4>
                <p class="text-xs text-blue-100/70 mt-2">
                    {{ __('This product is verified and authentic. You are running version 2.4.0-pro.') }}
                </p>
            </div>
        </div>
    </div>
</div>
