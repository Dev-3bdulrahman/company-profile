<div class="blog-page">
    {{-- Page Header --}}
    <section class="relative pt-32 pb-20 px-4 sm:px-6 lg:px-8 overflow-hidden">
        <div class="absolute inset-0 grid-pattern opacity-30"></div>
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-primary/10 blur-3xl rounded-full"></div>
        <div class="relative max-w-4xl mx-auto text-center">
            <span class="inline-block px-4 py-1.5 rounded-full bg-primary/10 text-primary text-sm font-bold tracking-wider uppercase mb-4 animate-fade-in">
                {{ __('landing.blog.eyebrow') }}
            </span>
            <h1 class="text-5xl sm:text-6xl font-black mb-4 gradient-text">
                {{ __('landing.blog.title') }}
            </h1>
            <p class="text-lg text-muted-foreground max-w-2xl mx-auto font-medium">
                {{ __('landing.blog.subtitle') }}
            </p>
        </div>
    </section>

    {{-- Blog Grid --}}
    <section class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            @if($posts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($posts as $post)
                        <article class="group bg-card border border-border rounded-3xl overflow-hidden hover:shadow-2xl hover:shadow-primary/5 transition-all duration-500 hover:-translate-y-2">
                            {{-- Image --}}
                            <div class="relative aspect-[16/10] overflow-hidden">
                                @if($post->featured_image)
                                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->getTranslation('title', app()->getLocale()) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full bg-secondary flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-muted-foreground/30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                
                                @if($post->category)
                                    <span class="absolute top-4 {{ app()->getLocale() == 'ar' ? 'right-4' : 'left-4' }} px-3 py-1 rounded-full bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm text-xs font-bold shadow-lg">
                                        {{ $post->category->getTranslation('name', app()->getLocale()) }}
                                    </span>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="p-6">
                                <div class="flex items-center gap-3 mb-4 text-xs font-semibold text-muted-foreground">
                                    <span class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                        {{ $post->published_at->format('M d, Y') }}
                                    </span>
                                    <span class="w-1 h-1 rounded-full bg-border"></span>
                                    <span class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                                        {{ ceil(str_word_count(strip_tags($post->getTranslation('content', app()->getLocale()))) / 200) }} min read
                                    </span>
                                </div>

                                <h3 class="text-xl font-bold mb-3 group-hover:text-primary transition-colors line-clamp-2">
                                    <a href="{{ route('blog.show', $post->slug) }}" wire:navigate>
                                        {{ $post->getTranslation('title', app()->getLocale()) }}
                                    </a>
                                </h3>
                                
                                <p class="text-muted-foreground text-sm leading-relaxed mb-6 line-clamp-3">
                                    {{ $post->getTranslation('excerpt', app()->getLocale()) }}
                                </p>

                                <a href="{{ route('blog.show', $post->slug) }}" wire:navigate class="inline-flex items-center gap-2 text-sm font-black text-primary hover:gap-3 transition-all">
                                    {{ __('landing.blog.read_more') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 bg-card border border-dashed border-border rounded-3xl">
                    <div class="w-20 h-20 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><path d="M8 7h6"/><path d="M8 11h8"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">{{ __('landing.blog.no_posts') }}</h3>
                </div>
            @endif
        </div>
    </section>

    <x-sections.cta />
</div>
