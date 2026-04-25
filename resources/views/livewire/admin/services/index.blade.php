<div>
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ __('Manage Services') }}</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('Manage and display your services') }}</p>
        </div>
        <button wire:click="openModal()"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-blue-700 transition-colors">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>{{ __('Add New Service') }}</span>
        </button>
    </div>

    <div class="mb-6">
        <input wire:model.live="search" type="text" placeholder="{{ __('Search services...') }}"
            class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none w-72">
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($services as $service)
        <div wire:key="service-{{ $service->id }}"
            class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden hover:shadow-md transition-shadow group">

            <div class="h-40 bg-gray-100 dark:bg-gray-800 relative overflow-hidden">
                @if($service->hero_image)
                <img src="{{ asset('storage/' . $service->hero_image) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                <div class="absolute inset-0 bg-black/10"></div>
                @else
                <div class="w-full h-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                    <i data-lucide="briefcase" class="w-12 h-12 text-white/30"></i>
                </div>
                @endif
                <span class="absolute top-3 right-3 text-xs px-2 py-1 rounded font-bold
                    {{ $service->status === 'published' ? 'bg-green-500 text-white' : 'bg-gray-500 text-white' }}">
                    {{ __(ucfirst($service->status)) }}
                </span>
            </div>

            <div class="p-5">
                <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 mb-1 line-clamp-1">
                    {{ $service->title[app()->getLocale()] ?? reset($service->title) }}
                </h3>
                <p class="text-gray-500 dark:text-gray-400 text-sm mb-4 line-clamp-2">
                    {{ isset($service->short_description) ? ($service->short_description[app()->getLocale()] ?? reset($service->short_description)) : '' }}
                </p>
                <div class="flex items-center justify-between border-t border-gray-50 dark:border-gray-800 pt-3">
                    <span class="text-xs text-gray-400 font-mono">{{ $service->slug }}</span>
                    <div class="flex items-center gap-2">
                        <button wire:click="openModal({{ $service->id }})"
                            class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </button>
                        <button 
                            wire:click="$dispatch('swal:confirm', { 
                                title: 'Delete Service',
                                text: 'Are you sure you want to delete this service?',
                                onConfirm: 'delete',
                                params: { id: {{ $service->id }} }
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
            <i data-lucide="briefcase" class="w-12 h-12 mx-auto mb-3 opacity-30"></i>
            <p class="font-medium">{{ __('No services yet.') }}</p>
        </div>
        @endforelse
    </div>

    <div class="mt-6">{{ $services->links() }}</div>

    {{-- Modal --}}
    @if($isModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="relative flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="absolute inset-0 bg-gray-500/75" wire:click="closeModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-middle bg-white dark:bg-gray-900 rounded-xl text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-2xl w-full">
                <form wire:submit="save">
                    <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                            {{ $service_id ? __('Edit Service') : __('Add New Service') }}
                        </h3>
                        <button wire:click="closeModal()" type="button" class="text-gray-400 hover:text-gray-500">
                            <i data-lucide="x" class="w-6 h-6"></i>
                        </button>
                    </div>
                    <div class="px-6 py-6 space-y-5 max-h-[70vh] overflow-y-auto">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Hero Image') }}</label>
                            <div class="flex items-center gap-4">
                                <div class="w-24 h-24 rounded-xl border-2 border-dashed border-gray-200 dark:border-gray-700 overflow-hidden flex items-center justify-center bg-gray-50 dark:bg-gray-800 shrink-0">
                                    @if($hero_image && method_exists($hero_image, 'temporaryUrl'))
                                        <img src="{{ $hero_image->temporaryUrl() }}" class="w-full h-full object-cover">
                                    @elseif($existing_hero_image)
                                        <img src="{{ asset('storage/' . $existing_hero_image) }}" class="w-full h-full object-cover">
                                    @else
                                        <i data-lucide="image" class="w-8 h-8 text-gray-300"></i>
                                    @endif
                                </div>
                                <div>
                                    <input type="file" wire:model="hero_image" id="svc-image" accept="image/*" class="hidden">
                                    <label for="svc-image" class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 cursor-pointer transition-all">
                                        <i data-lucide="upload" class="w-4 h-4"></i>{{ __('Choose Image') }}
                                    </label>
                                    <div wire:loading wire:target="hero_image" class="mt-1 text-xs text-blue-600">{{ __('Uploading...') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Title') }} (العربية)</label>
                                <input wire:model="title.ar" type="text" dir="rtl" class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                                @error('title.ar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Title') }} (English)</label>
                                <input wire:model="title.en" type="text" dir="ltr" class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                                @error('title.en') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Slug') }}</label>
                                <input wire:model="slug" type="text" dir="ltr" class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Status') }}</label>
                                <select wire:model="status" class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                                    <option value="draft">{{ __('Draft') }}</option>
                                    <option value="published">{{ __('Published') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Short Description') }} (العربية)</label>
                                <textarea wire:model="short_description.ar" rows="3" dir="rtl" class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-none"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Short Description') }} (English)</label>
                                <textarea wire:model="short_description.en" rows="3" dir="ltr" class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-none"></textarea>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-gray-100 dark:border-gray-800">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model="is_active" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                                <span class="ms-3 text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Visible on landing page') }}</span>
                            </label>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800/50 px-6 py-4 flex flex-row-reverse gap-3">
                        <button type="submit" class="inline-flex justify-center rounded-lg px-6 py-2 bg-blue-600 text-sm font-bold text-white hover:bg-blue-700 transition-colors">{{ __('Save Changes') }}</button>
                        <button wire:click="closeModal()" type="button" class="inline-flex justify-center rounded-lg border border-gray-300 dark:border-gray-600 px-4 py-2 bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 transition-colors">{{ __('Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
