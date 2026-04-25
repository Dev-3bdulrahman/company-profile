@props(['label', 'count_name', 'label_ar_name', 'label_en_name'])

<div class="bg-gray-50 dark:bg-gray-800/50 rounded-xl p-4 space-y-3 border border-gray-100 dark:border-gray-700">
    <h3 class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $label }}</h3>
    <div class="space-y-1">
        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ __('Count') }}</span>
        <input type="text" wire:model="{{ $count_name }}" dir="ltr"
               class="w-full px-3 py-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-sm font-bold text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
    </div>
    <div class="grid grid-cols-2 gap-2">
        <div class="space-y-1">
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ __('Arabic') }}</span>
            <input type="text" wire:model="{{ $label_ar_name }}" dir="rtl"
                   class="w-full px-3 py-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-sm text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
        </div>
        <div class="space-y-1">
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ __('English') }}</span>
            <input type="text" wire:model="{{ $label_en_name }}" dir="ltr"
                   class="w-full px-3 py-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-sm text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
        </div>
    </div>
</div>
