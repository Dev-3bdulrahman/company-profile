<div>
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ __('Manage Blog') }}</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('Manage and publish your blog posts') }}</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.blog.categories') }}" wire:navigate
               class="flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                <i data-lucide="folder" class="w-4 h-4"></i>
                {{ __('Categories') }}
            </a>
            <a href="{{ route('admin.blog.create') }}" wire:navigate
               class="bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-blue-700 transition-colors text-sm font-semibold">
                <i data-lucide="plus" class="w-4 h-4"></i>
                {{ __('Add Post') }}
            </a>
        </div>
    </div>

    {{-- Filters --}}
    <div class="flex flex-wrap gap-3 mb-6">
        <input wire:model.live="search" type="text" placeholder="{{ __('Search...') }}"
            class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none w-64">
        <select wire:model.live="filterStatus"
            class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            <option value="">{{ __('All Statuses') }}</option>
            <option value="draft">{{ __('Draft') }}</option>
            <option value="published">{{ __('Published') }}</option>
            <option value="scheduled">{{ __('Scheduled') }}</option>
        </select>
        <select wire:model.live="filterCategory"
            class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            <option value="">{{ __('All Categories') }}</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}">{{ is_array($cat->name) ? ($cat->name[app()->getLocale()] ?? reset($cat->name)) : $cat->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Posts Grid --}}
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($posts as $post)
        <div wire:key="post-{{ $post->id }}"
            class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden hover:shadow-md transition-shadow group">

            <div class="h-40 bg-gray-100 dark:bg-gray-800 relative overflow-hidden">
                @if($post->featured_image)
                <img src="{{ asset('storage/' . $post->featured_image) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                <div class="absolute inset-0 bg-black/10"></div>
                @else
                <div class="w-full h-full bg-gradient-to-br from-blue-400 to-indigo-600 flex items-center justify-center">
                    <i data-lucide="newspaper" class="w-12 h-12 text-white/30"></i>
                </div>
                @endif
                <span class="absolute top-3 right-3 text-xs px-2 py-1 rounded font-bold
                    {{ $post->status === 'published' ? 'bg-green-500 text-white' : ($post->status === 'scheduled' ? 'bg-amber-500 text-white' : 'bg-gray-500 text-white') }}">
                    {{ __($post->status) }}
                </span>
            </div>

            <div class="p-5">
                @if($post->category)
                <span class="inline-block text-xs bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 px-2 py-0.5 rounded font-medium mb-2">
                    {{ is_array($post->category->name) ? ($post->category->name[app()->getLocale()] ?? reset($post->category->name)) : $post->category->name }}
                </span>
                @endif
                <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 mb-1 line-clamp-1">
                    {{ is_array($post->title) ? ($post->title[app()->getLocale()] ?? reset($post->title)) : $post->title }}
                </h3>
                <p class="text-gray-500 dark:text-gray-400 text-sm mb-4 line-clamp-2">
                    {{ is_array($post->excerpt) ? ($post->excerpt[app()->getLocale()] ?? reset($post->excerpt)) : $post->excerpt }}
                </p>
                <div class="flex items-center justify-between border-t border-gray-50 dark:border-gray-800 pt-3">
                    <span class="text-xs text-gray-400">{{ $post->published_at?->format('Y-m-d') ?? __('Draft') }}</span>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.blog.edit', $post->id) }}" wire:navigate
                            class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </a>
                        <button
                            wire:click="$dispatch('swal:confirm', {
                                title: 'Hide Post',
                                text: '{{ $post->status === 'published' ? 'Are you sure you want to hide this post?' : 'Are you sure you want to publish this post?' }}',
                                onConfirm: 'toggleStatus',
                                params: { id: {{ $post->id }} }
                            })"
                            class="p-2 rounded-lg transition-colors {{ $post->status === 'published' ? 'text-green-500 hover:text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/30' : 'text-gray-400 hover:text-green-600 hover:bg-green-50 dark:hover:bg-green-900/30' }}">
                            <i data-lucide="{{ $post->status === 'published' ? 'eye' : 'eye-off' }}" class="w-4 h-4"></i>
                        </button>
                        <button 
                            wire:click="$dispatch('swal:confirm', { 
                                title: 'Delete Post',
                                text: 'Are you sure you want to delete this post?',
                                onConfirm: 'delete',
                                params: { id: {{ $post->id }} }
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
            <i data-lucide="newspaper" class="w-12 h-12 mx-auto mb-3 opacity-30"></i>
            <p class="font-medium">{{ __('No posts yet.') }}</p>
            <a href="{{ route('admin.blog.create') }}" wire:navigate class="mt-3 inline-flex items-center gap-2 text-blue-600 text-sm font-semibold hover:underline">
                <i data-lucide="plus" class="w-4 h-4"></i>{{ __('Add your first post') }}
            </a>
        </div>
        @endforelse
    </div>
</div>
