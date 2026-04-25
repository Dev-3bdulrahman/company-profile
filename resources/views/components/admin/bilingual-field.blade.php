@props(['label', 'name_ar', 'name_en', 'type' => 'input'])

<div class="space-y-2">
    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $label }}</label>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div class="space-y-1">
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ __('Arabic') }}</span>
            @if($type === 'textarea')
            <textarea wire:model="{{ $name_ar }}" rows="3" dir="rtl"
                      class="w-full px-3 py-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-sm text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none transition-all"></textarea>
            @else
            <input type="text" wire:model="{{ $name_ar }}" dir="rtl"
                   class="w-full px-3 py-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-sm text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
            @endif
        </div>
        <div class="space-y-1">
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ __('English') }}</span>
            @if($type === 'textarea')
            <textarea wire:model="{{ $name_en }}" rows="3" dir="ltr"
                      class="w-full px-3 py-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-sm text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none transition-all"></textarea>
            @else
            <input type="text" wire:model="{{ $name_en }}" dir="ltr"
                   class="w-full px-3 py-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-sm text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
            @endif
        </div>
    </div>
</div>
