<div>
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ __('Hero Section') }}</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('Control all homepage sections from the dashboard') }}</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" target="_blank"
               class="flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                <i data-lucide="external-link" class="w-4 h-4"></i>
                {{ __('Preview Site') }}
            </a>
            <button wire:click="save"
                class="flex items-center gap-2 bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-bold hover:bg-blue-700 transition-colors">
                <i data-lucide="save" class="w-4 h-4"></i>
                {{ __('Save Changes') }}
            </button>
        </div>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
            <div class="p-5 border-b border-gray-50 dark:border-gray-800 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center">
                    <i data-lucide="sparkles" class="w-4 h-4 text-blue-600"></i>
                </div>
                <h3 class="font-bold text-gray-900 dark:text-gray-100 text-sm">{{ __('Eyebrow Text') }}</h3>
            </div>
            <div class="p-5 space-y-3">
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">{{ __('Arabic') }}</label>
                    <input wire:model="eyebrow_ar" type="text" dir="rtl"
                        class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">{{ __('English') }}</label>
                    <input wire:model="eyebrow_en" type="text" dir="ltr"
                        class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
            <div class="p-5 border-b border-gray-50 dark:border-gray-800 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center">
                    <i data-lucide="type" class="w-4 h-4 text-purple-600"></i>
                </div>
                <h3 class="font-bold text-gray-900 dark:text-gray-100 text-sm">{{ __('Title Line 1') }}</h3>
            </div>
            <div class="p-5 space-y-3">
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">{{ __('Arabic') }}</label>
                    <input wire:model="title1_ar" type="text" dir="rtl"
                        class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">{{ __('English') }}</label>
                    <input wire:model="title1_en" type="text" dir="ltr"
                        class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
            <div class="p-5 border-b border-gray-50 dark:border-gray-800 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-green-50 dark:bg-green-900/20 flex items-center justify-center">
                    <i data-lucide="zap" class="w-4 h-4 text-green-600"></i>
                </div>
                <h3 class="font-bold text-gray-900 dark:text-gray-100 text-sm">{{ __('Title Line 2 (Gradient)') }}</h3>
            </div>
            <div class="p-5 space-y-3">
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">{{ __('Arabic') }}</label>
                    <input wire:model="title2_ar" type="text" dir="rtl"
                        class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">{{ __('English') }}</label>
                    <input wire:model="title2_en" type="text" dir="ltr"
                        class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
            <div class="p-5 border-b border-gray-50 dark:border-gray-800 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-orange-50 dark:bg-orange-900/20 flex items-center justify-center">
                    <i data-lucide="mouse-pointer-click" class="w-4 h-4 text-orange-600"></i>
                </div>
                <h3 class="font-bold text-gray-900 dark:text-gray-100 text-sm">{{ __('Button 1 Text') }}</h3>
            </div>
            <div class="p-5 space-y-3">
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">{{ __('Arabic') }}</label>
                    <input wire:model="cta1_ar" type="text" dir="rtl"
                        class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">{{ __('English') }}</label>
                    <input wire:model="cta1_en" type="text" dir="ltr"
                        class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
                <div class="pt-2 border-t border-gray-100 dark:border-gray-800">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1 flex items-center gap-1">
                        <i data-lucide="link" class="w-3 h-3"></i> {{ __('Link URL') }}
                    </label>
                    <input wire:model="cta1_url" type="text" dir="ltr" placeholder="#contact or /contact"
                        class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm font-mono focus:ring-2 focus:ring-orange-400 outline-none transition-all">
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
            <div class="p-5 border-b border-gray-50 dark:border-gray-800 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-pink-50 dark:bg-pink-900/20 flex items-center justify-center">
                    <i data-lucide="arrow-right" class="w-4 h-4 text-pink-600"></i>
                </div>
                <h3 class="font-bold text-gray-900 dark:text-gray-100 text-sm">{{ __('Button 2 Text') }}</h3>
            </div>
            <div class="p-5 space-y-3">
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">{{ __('Arabic') }}</label>
                    <input wire:model="cta2_ar" type="text" dir="rtl"
                        class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">{{ __('English') }}</label>
                    <input wire:model="cta2_en" type="text" dir="ltr"
                        class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
                <div class="pt-2 border-t border-gray-100 dark:border-gray-800">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1 flex items-center gap-1">
                        <i data-lucide="link" class="w-3 h-3"></i> {{ __('Link URL') }}
                    </label>
                    <input wire:model="cta2_url" type="text" dir="ltr" placeholder="#projects or /projects"
                        class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm font-mono focus:ring-2 focus:ring-pink-400 outline-none transition-all">
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden md:col-span-2 lg:col-span-3">
            <div class="p-5 border-b border-gray-50 dark:border-gray-800 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center">
                    <i data-lucide="align-left" class="w-4 h-4 text-indigo-600"></i>
                </div>
                <h3 class="font-bold text-gray-900 dark:text-gray-100 text-sm">{{ __('Subtitle') }}</h3>
            </div>
            <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">{{ __('Arabic') }}</label>
                    <textarea wire:model="subtitle_ar" rows="3" dir="rtl"
                        class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">{{ __('English') }}</label>
                    <textarea wire:model="subtitle_en" rows="3" dir="ltr"
                        class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all resize-none"></textarea>
                </div>
            </div>
        </div>

        </div>

        {{-- Hero Background Image (Full Width Card) --}}
        <div class="mt-6 bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
            <div class="p-5 border-b border-gray-50 dark:border-gray-800 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-rose-50 dark:bg-rose-900/20 flex items-center justify-center">
                    <i data-lucide="image" class="w-4 h-4 text-rose-600"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 dark:text-gray-100 text-sm">{{ __('Hero Background Image') }}</h3>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ __('The main background photo shown behind the hero text on the homepage.') }}</p>
                </div>
            </div>
            <div class="p-5">
                <div class="relative group cursor-pointer">
                    <div class="w-full aspect-video rounded-xl overflow-hidden bg-gray-50 dark:bg-gray-800 border-2 border-dashed border-gray-200 dark:border-gray-700 flex items-center justify-center transition-colors hover:border-blue-400">
                        @if ($hero_image && !is_string($hero_image))
                            <img src="{{ $hero_image->temporaryUrl() }}" class="w-full h-full object-cover">
                        @elseif ($existing_hero_image)
                            <img src="{{ asset('storage/' . $existing_hero_image) }}" class="w-full h-full object-cover">
                        @else
                            <div class="text-center text-gray-300 dark:text-gray-600 py-10">
                                <i data-lucide="image-plus" class="w-12 h-12 mx-auto mb-3"></i>
                                <p class="text-sm font-semibold">{{ __('Click to upload a hero image') }}</p>
                                <p class="text-xs mt-1 opacity-60">PNG, JPG, WEBP — {{ __('Recommended') }}: 1920×1080</p>
                            </div>
                        @endif
                        @if ($existing_hero_image || ($hero_image && !is_string($hero_image)))
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center rounded-xl">
                            <span class="text-white font-bold text-sm flex items-center gap-2 bg-black/30 px-4 py-2 rounded-full backdrop-blur-sm">
                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                {{ __('Change Image') }}
                            </span>
                        </div>
                        @endif
                    </div>
                    <input type="file" wire:model="hero_image" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer">
                </div>
                <div wire:loading wire:target="hero_image" class="mt-3 flex items-center gap-2 text-xs text-blue-600 font-semibold">
                    <svg class="animate-spin h-3 w-3" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    {{ __('Uploading...') }}
                </div>
            </div>
        </div>

    </div>
</div>
