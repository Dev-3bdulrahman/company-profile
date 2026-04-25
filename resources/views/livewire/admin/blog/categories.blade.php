<div>
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.blog') }}" wire:navigate
               class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ __('Blog Categories') }}</h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('Manage blog post categories') }}</p>
            </div>
        </div>
        <button wire:click="create"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-blue-700 transition-colors text-sm font-semibold">
            <i data-lucide="plus" class="w-4 h-4"></i>
            {{ __('Add Category') }}
        </button>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($categories as $cat)
        <div wire:key="cat-{{ $cat->id }}"
            class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden hover:shadow-md transition-shadow group">
            <div class="p-6">
                <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i data-lucide="folder" class="w-6 h-6 text-blue-600"></i>
                </div>
                <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-1">
                    {{ is_array($cat->name) ? ($cat->name[app()->getLocale()] ?? reset($cat->name)) : $cat->name }}
                </h3>
                <p class="text-xs text-gray-400 font-mono mb-4">{{ $cat->slug }}</p>
                <div class="flex items-center justify-end gap-2 border-t border-gray-50 dark:border-gray-800 pt-3">
                    <button wire:click="edit({{ $cat->id }})"
                        class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors">
                        <i data-lucide="pencil" class="w-4 h-4"></i>
                    </button>
                    <button wire:click="confirmDelete({{ $cat->id }})"
                        class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-4 text-center py-16 text-gray-400">
            <i data-lucide="folder" class="w-12 h-12 mx-auto mb-3 opacity-30"></i>
            <p class="font-medium">{{ __('No categories yet.') }}</p>
        </div>
        @endforelse
    </div>

    {{-- Modal --}}
    <div x-data="{ open: @entangle('showModal') }" x-show="open" x-cloak
        class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="relative flex items-center justify-center min-h-screen px-4">
            <div x-show="open" @click="open = false" class="absolute inset-0 bg-gray-500/75"></div>
            <div x-show="open"
                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                class="relative bg-white dark:bg-gray-900 rounded-xl shadow-xl w-full max-w-md z-10">
                <form wire:submit="save">
                    <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $category_id ? __('Edit Category') : __('Add Category') }}</h3>
                        <button @click="open = false" type="button" class="text-gray-400 hover:text-gray-500"><i data-lucide="x" class="w-6 h-6"></i></button>
                    </div>
                    <div class="px-6 py-6 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Name') }} (العربية)</label>
                                <input wire:model="name_ar" type="text" dir="rtl"
                                    class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                                @error('name_ar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Name') }} (English)</label>
                                <input wire:model="name_en" type="text" dir="ltr"
                                    class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                                @error('name_en') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Slug') }}</label>
                            <input wire:model="slug" type="text" dir="ltr" placeholder="{{ __('Auto-generated if empty') }}"
                                class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800/50 px-6 py-4 flex flex-row-reverse gap-3">
                        <button type="submit" class="inline-flex justify-center rounded-lg px-6 py-2 bg-blue-600 text-sm font-bold text-white hover:bg-blue-700 transition-colors">{{ __('Save Changes') }}</button>
                        <button @click="open = false" type="button" class="inline-flex justify-center rounded-lg border border-gray-300 dark:border-gray-600 px-4 py-2 bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 transition-colors">{{ __('Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Delete Modal --}}
    <div x-data="{ open: @entangle('showDeleteModal') }" x-show="open" x-cloak
        class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div x-show="open" @click="open = false" class="absolute inset-0 bg-gray-500/75"></div>
            <div x-show="open" class="relative bg-white dark:bg-gray-900 rounded-xl shadow-xl p-6 max-w-sm w-full text-center z-10">
                <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="alert-triangle" class="w-6 h-6 text-red-600"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">{{ __('Delete Category') }}</h3>
                <p class="text-sm text-gray-500 mb-6">{{ __('Are you sure you want to delete this category?') }}</p>
                <div class="flex gap-3 justify-center">
                    <button wire:click="delete" class="px-5 py-2 bg-red-600 text-white rounded-lg text-sm font-bold hover:bg-red-700 transition-colors">{{ __('Confirm Delete') }}</button>
                    <button @click="open = false" type="button" class="px-5 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 transition-colors">{{ __('Cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
