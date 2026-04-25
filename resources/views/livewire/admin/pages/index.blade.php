<div>
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ __('Pages') }}</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ __('Manage dynamic website pages') }}</p>
        </div>
        <a href="{{ route('admin.pages.create') }}" wire:navigate class="flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/20">
            <i data-lucide="plus" class="w-4 h-4"></i>
            {{ __('Add Page') }}
        </a>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($pages as $page)
        <div wire:key="page-{{ $page->id }}"
            class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden hover:shadow-md transition-shadow group">

            <div class="h-40 bg-gray-100 dark:bg-gray-800 relative overflow-hidden">
                <div class="w-full h-full bg-gradient-to-br from-indigo-400 to-purple-600 flex items-center justify-center">
                    <i data-lucide="file-text" class="w-12 h-12 text-white/30"></i>
                </div>
                @if($page->is_active)
                    <span class="absolute top-3 right-3 text-xs px-2 py-1 rounded font-bold bg-green-500 text-white">
                        {{ __('Active') }}
                    </span>
                @else
                    <span class="absolute top-3 right-3 text-xs px-2 py-1 rounded font-bold bg-gray-500 text-white">
                        {{ __('Inactive') }}
                    </span>
                @endif
                @if($page->is_system)
                    <span class="absolute top-3 left-3 text-xs px-2 py-1 rounded font-bold bg-blue-500 text-white">
                        {{ __('System') }}
                    </span>
                @endif
            </div>

            <div class="p-5">
                <span class="inline-block text-xs bg-gray-50 dark:bg-gray-800 text-gray-500 dark:text-gray-400 px-2 py-0.5 rounded font-medium mb-2">
                    /{{ $page->slug }}
                </span>
                <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 mb-1 line-clamp-1">
                    {{ $page->getTranslation('title', 'ar') }}
                </h3>
                <p class="text-gray-400 text-xs mb-4">{{ $page->getTranslation('title', 'en') }}</p>
                <div class="flex items-center justify-between border-t border-gray-50 dark:border-gray-800 pt-3">
                    <span class="text-xs text-gray-400">{{ __('Order') }}: {{ $page->sort_order }}</span>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.pages.edit', $page->id) }}" wire:navigate
                            class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </a>
                        <button
                            wire:click="$dispatch('swal:confirm', {
                                title: '{{ $page->is_active ? 'Hide Page' : 'Activate Page' }}',
                                text: '{{ $page->is_active ? 'Are you sure you want to hide this page?' : 'Are you sure you want to activate this page?' }}',
                                onConfirm: 'toggleStatus',
                                params: { id: {{ $page->id }} }
                            })"
                            class="p-2 rounded-lg transition-colors {{ $page->is_active ? 'text-green-500 hover:text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/30' : 'text-gray-400 hover:text-green-600 hover:bg-green-50 dark:hover:bg-green-900/30' }}">
                            <i data-lucide="{{ $page->is_active ? 'eye' : 'eye-off' }}" class="w-4 h-4"></i>
                        </button>
                        <button
                            wire:click="$dispatch('swal:confirm', {
                                title: 'Delete Page',
                                text: 'Are you sure you want to delete this page?',
                                onConfirm: 'delete',
                                params: { id: {{ $page->id }} }
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
            <i data-lucide="file-text" class="w-12 h-12 mx-auto mb-3 opacity-30"></i>
            <p class="font-medium">{{ __('No pages yet.') }}</p>
            <a href="{{ route('admin.pages.create') }}" wire:navigate class="mt-3 inline-flex items-center gap-2 text-blue-600 text-sm font-semibold hover:underline">
                <i data-lucide="plus" class="w-4 h-4"></i>{{ __('Add your first page') }}
            </a>
        </div>
        @endforelse
    </div>

    @if($pages->hasPages())
    <div class="mt-6">
        {{ $pages->links() }}
    </div>
    @endif
</div>
