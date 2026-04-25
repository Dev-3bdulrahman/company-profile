<div>
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ __('CTA Section') }}</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('Control all homepage sections from the dashboard') }}</p>
        </div>
        <button wire:click="save"
            class="flex items-center gap-2 bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-bold hover:bg-blue-700 transition-colors">
            <i data-lucide="save" class="w-4 h-4"></i>
            {{ __('Save Changes') }}
        </button>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
            <div class="p-5 border-b border-gray-50 dark:border-gray-800 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center">
                    <i data-lucide="heading-1" class="w-4 h-4 text-indigo-600"></i>
                </div>
                <h3 class="font-bold text-gray-900 dark:text-gray-100 text-sm">{{ __('Section Title') }}</h3>
            </div>
            <div class="p-5 space-y-3">
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">{{ __('Arabic') }}</label>
                    <input wire:model="title_ar" type="text" dir="rtl"
                        class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">{{ __('English') }}</label>
                    <input wire:model="title_en" type="text" dir="ltr"
                        class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
            <div class="p-5 border-b border-gray-50 dark:border-gray-800 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-orange-50 dark:bg-orange-900/20 flex items-center justify-center">
                    <i data-lucide="mouse-pointer-click" class="w-4 h-4 text-orange-600"></i>
                </div>
                <h3 class="font-bold text-gray-900 dark:text-gray-100 text-sm">{{ __('CTA Button Text') }}</h3>
            </div>
            <div class="p-5 space-y-3">
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">{{ __('Arabic') }}</label>
                    <input wire:model="button_ar" type="text" dir="rtl"
                        class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">{{ __('English') }}</label>
                    <input wire:model="button_en" type="text" dir="ltr"
                        class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden md:col-span-2 lg:col-span-3">
            <div class="p-5 border-b border-gray-50 dark:border-gray-800 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center">
                    <i data-lucide="align-left" class="w-4 h-4 text-blue-600"></i>
                </div>
                <h3 class="font-bold text-gray-900 dark:text-gray-100 text-sm">{{ __('Section Subtitle') }}</h3>
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
</div>
