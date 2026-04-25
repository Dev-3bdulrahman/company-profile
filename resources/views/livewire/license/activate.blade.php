<div class="bg-white rounded-[2rem] shadow-2xl shadow-blue-900/10 p-10 border border-slate-100">
    <div class="w-20 h-20 bg-blue-50 rounded-3xl flex items-center justify-center mx-auto mb-8">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/>
        </svg>
    </div>
    
    <h1 class="text-2xl font-extrabold text-slate-900 mb-2 text-center">{{ __('Activate Installation') }}</h1>
    <p class="text-slate-500 text-sm mb-8 text-center">
        {{ __('Please enter your license key to unlock the product.') }}
    </p>

    <form wire:submit="activate" class="space-y-6">
        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 px-1">{{ __('License Key') }}</label>
            <input type="text" wire:model="license_key" placeholder="XXXX-XXXX-XXXX-XXXX" 
                class="w-full px-5 py-4 bg-slate-50 border-transparent rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white transition-all text-sm font-mono text-center tracking-widest uppercase">
            @error('license_key') <span class="text-red-500 text-[10px] mt-1 px-1 font-bold">{{ $message }}</span> @enderror
        </div>

        @if($error_message)
            <div class="p-4 bg-red-50 text-red-600 rounded-2xl text-xs font-bold border border-red-100 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ $error_message }}
            </div>
        @endif

        @if($success_message)
            <div class="p-4 bg-green-50 text-green-600 rounded-2xl text-xs font-bold border border-green-100 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                {{ $success_message }}
            </div>
        @endif

        <button type="submit" wire:loading.attr="disabled"
            class="inline-flex items-center justify-center w-full py-4 bg-blue-600 text-white rounded-2xl font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-600/20 disabled:opacity-50">
            <span wire:loading.remove>{{ __('Activate Now') }}</span>
            <span wire:loading>{{ __('Verifying...') }}</span>
        </button>
    </form>

    <div class="mt-8 pt-8 border-t border-slate-100 flex items-center justify-center">
        <a href="/" class="text-xs font-bold text-slate-400 hover:text-blue-600 transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            {{ __('Back to Website') }}
        </a>
    </div>
</div>
