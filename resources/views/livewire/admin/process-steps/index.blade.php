<div>
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ __('Manage Process Steps') }}</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('Define your workflow steps') }}</p>
        </div>
        <button wire:click="openModal()"
            class="bg-amber-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-amber-700 transition-colors">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>{{ __('Add Process Step') }}</span>
        </button>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($steps as $index => $step)
        <div wire:key="step-{{ $step->id }}"
            class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden hover:shadow-md transition-shadow group">
            <div class="p-6">
                <div class="text-5xl font-black text-blue-600/10 dark:text-blue-400/10 mb-4 leading-none">
                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                </div>
                <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-2 text-base">
                    {{ $step->title[app()->getLocale()] ?? reset($step->title) }}
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 mb-4">
                    {{ $step->description[app()->getLocale()] ?? reset($step->description) }}
                </p>
                <div class="flex items-center justify-between border-t border-gray-50 dark:border-gray-800 pt-3">
                    <button wire:click="toggleStatus({{ $step->id }})"
                        class="text-xs px-3 py-1 rounded-full font-bold {{ $step->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $step->is_active ? __('Active') : __('Inactive') }}
                    </button>
                    <div class="flex items-center gap-2">
                        <button wire:click="openModal({{ $step->id }})"
                            class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </button>
                        <button 
                            wire:click="$dispatch('swal:confirm', { 
                                title: 'Delete Step',
                                text: 'Are you sure you want to delete this step?',
                                onConfirm: 'delete',
                                params: { id: {{ $step->id }} }
                            })"
                            class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-4 text-center py-16 text-gray-400">
            <i data-lucide="list-checks" class="w-12 h-12 mx-auto mb-3 opacity-30"></i>
            <p class="font-medium">{{ __('No process steps yet.') }}</p>
        </div>
        @endforelse
    </div>

    @if($isModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="relative flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="absolute inset-0 bg-gray-500/75" wire:click="closeModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-middle bg-white dark:bg-gray-900 rounded-xl text-right overflow-hidden shadow-xl transform sm:my-8 sm:max-w-lg w-full">
                <form wire:submit="save">
                    <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $step_id ? __('Edit Step') : __('Add Process Step') }}</h3>
                        <button wire:click="closeModal()" type="button" class="text-gray-400 hover:text-gray-500"><i data-lucide="x" class="w-6 h-6"></i></button>
                    </div>
                    <div class="px-6 py-6 space-y-4 max-h-[70vh] overflow-y-auto">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Title') }} (العربية)</label>
                                <input wire:model="title.ar" type="text" dir="rtl" class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 outline-none">
                                @error('title.ar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Title') }} (English)</label>
                                <input wire:model="title.en" type="text" dir="ltr" class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 outline-none">
                                @error('title.en') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Description') }} (العربية)</label>
                                <textarea wire:model="description.ar" rows="3" dir="rtl" class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 outline-none resize-none"></textarea>
                                @error('description.ar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Description') }} (English)</label>
                                <textarea wire:model="description.en" rows="3" dir="ltr" class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 outline-none resize-none"></textarea>
                                @error('description.en') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Sort Order') }}</label>
                                <input wire:model="sort_order" type="number" class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 outline-none">
                            </div>
                            <div class="flex items-end pb-2">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model="is_active" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                                    <span class="ms-2 text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Active') }}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800/50 px-6 py-4 flex flex-row-reverse gap-3">
                        <button type="submit" class="inline-flex justify-center rounded-lg px-6 py-2 bg-amber-600 text-sm font-bold text-white hover:bg-amber-700 transition-colors">{{ __('Save Changes') }}</button>
                        <button wire:click="closeModal()" type="button" class="inline-flex justify-center rounded-lg border border-gray-300 dark:border-gray-600 px-4 py-2 bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 transition-colors">{{ __('Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
