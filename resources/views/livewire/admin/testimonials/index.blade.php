<div>
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ __('Manage Testimonials') }}</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('Manage client testimonials') }}</p>
        </div>
        <button wire:click="openModal()"
            class="bg-pink-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-pink-700 transition-colors">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>{{ __('Add New Testimonial') }}</span>
        </button>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($testimonials as $testimonial)
        <div wire:key="testimonial-{{ $testimonial->id }}"
            class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden hover:shadow-md transition-shadow group">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-pink-400 to-pink-600 flex items-center justify-center text-white font-black text-lg shrink-0">
                        {{ mb_substr(is_array($testimonial->name) ? ($testimonial->name[app()->getLocale()] ?? reset($testimonial->name)) : $testimonial->name, 0, 1) }}
                    </div>
                    <div class="flex gap-0.5">
                        @for($i = 1; $i <= 5; $i++)
                        <svg class="w-4 h-4 {{ $i <= $testimonial->stars ? 'text-amber-400 fill-amber-400' : 'text-gray-200 fill-gray-200' }}" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        @endfor
                    </div>
                </div>
                <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-0.5">
                    {{ is_array($testimonial->name) ? ($testimonial->name[app()->getLocale()] ?? reset($testimonial->name)) : $testimonial->name }}
                </h3>
                <p class="text-xs text-gray-400 mb-3">
                    {{ is_array($testimonial->role) ? ($testimonial->role[app()->getLocale()] ?? reset($testimonial->role)) : $testimonial->role }}
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 italic">
                    "{{ is_array($testimonial->text) ? ($testimonial->text[app()->getLocale()] ?? reset($testimonial->text)) : $testimonial->text }}"
                </p>
                <div class="flex items-center justify-between border-t border-gray-50 dark:border-gray-800 pt-4 mt-4">
                    <button wire:click="toggleStatus({{ $testimonial->id }})"
                        class="text-xs px-3 py-1 rounded-full font-bold {{ $testimonial->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400' }}">
                        {{ $testimonial->is_active ? __('Active') : __('Inactive') }}
                    </button>
                    <div class="flex items-center gap-2">
                        <button wire:click="openModal({{ $testimonial->id }})"
                            class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </button>
                        <button 
                            wire:click="$dispatch('swal:confirm', { 
                                title: 'Delete Testimonial',
                                text: 'Are you sure you want to delete this testimonial?',
                                onConfirm: 'delete',
                                params: { id: {{ $testimonial->id }} }
                            })"
                            class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-16 text-gray-400">
            <i data-lucide="message-square-quote" class="w-12 h-12 mx-auto mb-3 opacity-30"></i>
            <p class="font-medium">{{ __('No testimonials yet.') }}</p>
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
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $testimonial_id ? __('Edit Testimonial') : __('Add New Testimonial') }}</h3>
                        <button wire:click="closeModal()" type="button" class="text-gray-400 hover:text-gray-500"><i data-lucide="x" class="w-6 h-6"></i></button>
                    </div>
                    <div class="px-6 py-6 space-y-4 max-h-[70vh] overflow-y-auto">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Name') }} (العربية)</label>
                                <input wire:model="name.ar" type="text" dir="rtl" class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-pink-500 outline-none">
                                @error('name.ar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Name') }} (English)</label>
                                <input wire:model="name.en" type="text" dir="ltr" class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-pink-500 outline-none">
                                @error('name.en') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Role') }} (العربية)</label>
                                <input wire:model="role.ar" type="text" dir="rtl" class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-pink-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Role') }} (English)</label>
                                <input wire:model="role.en" type="text" dir="ltr" class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-pink-500 outline-none">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Text') }} (العربية)</label>
                                <textarea wire:model="text.ar" rows="3" dir="rtl" class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-pink-500 outline-none resize-none"></textarea>
                                @error('text.ar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Text') }} (English)</label>
                                <textarea wire:model="text.en" rows="3" dir="ltr" class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-pink-500 outline-none resize-none"></textarea>
                                @error('text.en') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Stars') }}</label>
                                <select wire:model="stars" class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-pink-500 outline-none">
                                    @for($i=1; $i<=5; $i++) <option value="{{ $i }}">{{ $i }} ★</option> @endfor
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Sort Order') }}</label>
                                <input wire:model="sort_order" type="number" class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-pink-500 outline-none">
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
                        <button type="submit" class="inline-flex justify-center rounded-lg px-6 py-2 bg-pink-600 text-sm font-bold text-white hover:bg-pink-700 transition-colors">{{ __('Save Changes') }}</button>
                        <button wire:click="closeModal()" type="button" class="inline-flex justify-center rounded-lg border border-gray-300 dark:border-gray-600 px-4 py-2 bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 transition-colors">{{ __('Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
