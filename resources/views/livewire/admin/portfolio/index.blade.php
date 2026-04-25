<div>
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ __('Manage Portfolio') }}</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('Manage and display your portfolio') }}</p>
        </div>
        <button wire:click="create"
            class="bg-orange-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-orange-700 transition-colors">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>{{ __('Add Portfolio Item') }}</span>
        </button>
    </div>

    <div class="relative">
        <div wire:loading wire:target="reorder"
            class="absolute inset-0 bg-white/50 dark:bg-gray-900/50 z-20 flex items-center justify-center backdrop-blur-[1px] rounded-xl">
            <div class="flex items-center gap-3 bg-white dark:bg-gray-800 px-6 py-3 rounded-full shadow-xl border border-gray-100 dark:border-gray-700">
                <span class="animate-spin rounded-full h-4 w-4 border-2 border-orange-600 border-t-transparent"></span>
                <span class="text-sm font-bold text-gray-700 dark:text-gray-200">{{ __('Saving order...') }}</span>
            </div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" x-data x-init="
            new Sortable($el, {
                animation: 150,
                ghostClass: 'opacity-50',
                handle: '.drag-handle',
                onEnd: (evt) => {
                    let items = Array.from($el.querySelectorAll('[data-id]')).map((el, index) => ({
                        id: el.getAttribute('data-id'), order: index + 1
                    }));
                    @this.reorder(items);
                }
            });">

            @forelse($portfolioItems as $item)
            <div wire:key="portfolio-item-{{ $item['id'] }}" data-id="{{ $item['id'] }}"
                class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden hover:shadow-md transition-shadow group relative">

                <div class="drag-handle absolute top-3 left-3 z-10 p-2 bg-orange-600 rounded-lg cursor-move opacity-0 group-hover:opacity-100 scale-90 group-hover:scale-100 transition-all duration-200 shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="5" r="1"/><circle cx="9" cy="12" r="1"/><circle cx="9" cy="19" r="1"/>
                        <circle cx="15" cy="5" r="1"/><circle cx="15" cy="12" r="1"/><circle cx="15" cy="19" r="1"/>
                    </svg>
                </div>

                <div class="h-40 bg-gray-100 dark:bg-gray-800 relative overflow-hidden">
                    @if($item['image'])
                    <img src="{{ asset('storage/' . $item['image']) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-black/10"></div>
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center">
                        <i data-lucide="image" class="w-12 h-12 text-white/30"></i>
                    </div>
                    @endif
                    <span class="absolute top-3 right-3 text-xs bg-black/50 text-white px-2 py-1 rounded font-bold">{{ $item['year'] }}</span>
                </div>

                <div class="p-5">
                    <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 mb-1">
                        {{ is_array($item['title']) ? ($item['title'][app()->getLocale()] ?? reset($item['title'])) : $item['title'] }}
                    </h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mb-4 line-clamp-2">
                        {{ is_array($item['description']) ? ($item['description'][app()->getLocale()] ?? reset($item['description'])) : $item['description'] }}
                    </p>
                    <div class="flex items-center justify-end gap-2 border-t border-gray-50 dark:border-gray-800 pt-3">
                        <button wire:click="toggleStatus({{ $item['id'] }})"
                            class="p-2 {{ ($item['is_active'] ?? true) ? 'text-green-600 hover:bg-green-50' : 'text-gray-400 hover:bg-gray-50' }} rounded-lg transition-colors"
                            title="{{ ($item['is_active'] ?? true) ? __('Hide Project') : __('Show Project') }}">
                            <i data-lucide="{{ ($item['is_active'] ?? true) ? 'eye' : 'eye-off' }}" class="w-4 h-4"></i>
                        </button>
                        <button wire:click="edit({{ $item['id'] }})"
                            class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </button>
                        <button 
                            wire:click="$dispatch('swal:confirm', { 
                                title: 'Delete Work',
                                text: 'Are you sure you want to delete this work?',
                                onConfirm: 'delete',
                                params: { id: {{ $item['id'] }} }
                            })"
                            class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-16 text-gray-400">
                <i data-lucide="layers" class="w-12 h-12 mx-auto mb-3 opacity-30"></i>
                <p class="font-medium">{{ __('No portfolio items yet.') }}</p>
            </div>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    {{-- Create/Edit Modal --}}
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="relative flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div @click="$wire.set('showModal', false)" class="absolute inset-0 bg-gray-500/75 transition-opacity"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block align-middle bg-white dark:bg-gray-900 rounded-xl text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg w-full">

                <form wire:submit="save">
                    <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                            {{ $portfolioId ? __('Edit Work') : __('Add Portfolio Item') }}
                        </h3>
                        <button @click="$wire.set('showModal', false)" type="button" class="text-gray-400 hover:text-gray-500">
                            <i data-lucide="x" class="w-6 h-6"></i>
                        </button>
                    </div>

                    <div class="px-6 py-6 space-y-5 max-h-[70vh] overflow-y-auto">

                        {{-- Image Upload --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Cover Image') }}</label>
                            <div class="flex items-center gap-4">
                                <div class="w-24 h-24 rounded-xl border-2 border-dashed border-gray-200 dark:border-gray-700 overflow-hidden flex items-center justify-center bg-gray-50 dark:bg-gray-800 shrink-0">
                                    @if($image)
                                        <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                                    @elseif($existing_image)
                                        <img src="{{ asset('storage/' . $existing_image) }}" class="w-full h-full object-cover">
                                    @else
                                        <i data-lucide="image" class="w-8 h-8 text-gray-300"></i>
                                    @endif
                                </div>
                                <div>
                                    <input type="file" wire:model="image" id="pf-image" accept="image/*" class="hidden">
                                    <label for="pf-image"
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 cursor-pointer transition-all">
                                        <i data-lucide="upload" class="w-4 h-4"></i>
                                        {{ __('Choose Image') }}
                                    </label>
                                    <div wire:loading wire:target="image" class="mt-1 text-xs text-blue-600">{{ __('Uploading...') }}</div>
                                    @error('image') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Titles --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Title') }} (العربية)</label>
                                <input wire:model="title_ar" type="text" dir="rtl"
                                    class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 outline-none transition-all">
                                @error('title_ar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Title') }} (English)</label>
                                <input wire:model="title_en" type="text" dir="ltr"
                                    class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 outline-none transition-all">
                                @error('title_en') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- Year + Visibility --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Year') }}</label>
                                <input wire:model="year" type="number" dir="ltr"
                                    class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 outline-none transition-all">
                                @error('year') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Sort Order') }}</label>
                                <input wire:model="sort_order" type="number"
                                    class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 outline-none transition-all">
                            </div>
                        </div>

                        {{-- Descriptions --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Description') }} (العربية)</label>
                                <textarea wire:model="description_ar" rows="3" dir="rtl"
                                    class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 outline-none transition-all resize-none"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Description') }} (English)</label>
                                <textarea wire:model="description_en" rows="3" dir="ltr"
                                    class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 outline-none transition-all resize-none"></textarea>
                            </div>
                        </div>

                        {{-- Visibility Toggle --}}
                        <div class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-gray-100 dark:border-gray-800">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model="is_active" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                                <span class="ms-3 text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Visible on landing page') }}</span>
                            </label>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-800/50 px-6 py-4 flex flex-row-reverse gap-3">
                        <button type="submit"
                            class="inline-flex justify-center rounded-lg px-6 py-2 bg-orange-600 text-sm font-bold text-white hover:bg-orange-700 transition-colors">
                            {{ __('Save Changes') }}
                        </button>
                        <button @click="$wire.set('showModal', false)" type="button"
                            class="inline-flex justify-center rounded-lg border border-gray-300 dark:border-gray-600 px-4 py-2 bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 transition-colors">
                            {{ __('Cancel') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
