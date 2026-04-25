<div class="blog-post-page">
    {{-- Post Hero --}}
    <section class="relative pt-32 pb-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            {{-- Breadcrumbs --}}
            <nav class="flex items-center gap-2 text-sm font-bold text-muted-foreground mb-8">
                <a href="{{ route('home') }}" wire:navigate class="hover:text-primary transition-colors">Home</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                <a href="{{ route('blog.index') }}" wire:navigate class="hover:text-primary transition-colors">Blog</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                <span class="text-foreground line-clamp-1">{{ $post->getTranslation('title', app()->getLocale()) }}</span>
            </nav>

            <div class="flex items-center gap-3 mb-6">
                @if($post->category)
                    <span class="px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-black uppercase tracking-wider">
                        {{ $post->category->getTranslation('name', app()->getLocale()) }}
                    </span>
                @endif
                <span class="text-sm font-bold text-muted-foreground">
                    {{ $post->published_at->format('M d, Y') }}
                </span>
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black mb-8 leading-[1.1]">
                {{ $post->getTranslation('title', app()->getLocale()) }}
            </h1>

            @if($post->featured_image)
                <div class="relative aspect-[21/9] rounded-[2rem] overflow-hidden shadow-2xl mb-16">
                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->getTranslation('title', app()->getLocale()) }}" class="w-full h-full object-cover">
                </div>
            @endif
        </div>
    </section>

    {{-- Content --}}
    <section class="pb-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="flex flex-col lg:flex-row gap-16">
                {{-- Main Content --}}
                <div class="flex-1">
                    <div class="prose prose-lg dark:prose-invert max-w-none prose-headings:font-black prose-headings:tracking-tight prose-p:text-muted-foreground prose-p:leading-relaxed prose-img:rounded-3xl prose-a:text-primary prose-a:font-bold prose-strong:text-foreground">
                        {!! $post->getTranslation('content', app()->getLocale()) !!}
                    </div>

                    {{-- Tags --}}
                    @if($post->tags->count() > 0)
                        <div class="mt-16 pt-8 border-t border-border">
                            <div class="flex flex-wrap gap-2">
                                @foreach($post->tags as $tag)
                                    <span class="px-4 py-2 rounded-xl bg-secondary text-secondary-foreground text-sm font-bold">
                                        #{{ $tag->getTranslation('name', app()->getLocale()) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <div class="lg:w-80 shrink-0">
                    <div class="sticky top-32 space-y-12">

                        {{-- Social Share --}}
                        <div class="space-y-4">
                            <h4 class="font-bold text-sm uppercase tracking-widest text-muted-foreground">Share Article</h4>
                            <div class="flex gap-3">
                                @php
                                    $shareUrl = urlencode(request()->url());
                                    $shareTitle = urlencode($post->getTranslation('title', app()->getLocale()));
                                @endphp
                                <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}" target="_blank" class="w-10 h-10 rounded-full bg-card border border-border flex items-center justify-center hover:bg-primary hover:text-white hover:border-primary transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" class="w-10 h-10 rounded-full bg-card border border-border flex items-center justify-center hover:bg-primary hover:text-white hover:border-primary transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ $shareUrl }}&title={{ $shareTitle }}" target="_blank" class="w-10 h-10 rounded-full bg-card border border-border flex items-center justify-center hover:bg-primary hover:text-white hover:border-primary transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Related Posts --}}
    @if($relatedPosts->count() > 0)
        <section class="py-20 bg-secondary/30 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-center justify-between mb-12">
                    <h2 class="text-3xl font-black">{{ __('landing.blog.related_posts') }}</h2>
                    <a href="{{ route('blog.index') }}" wire:navigate class="text-primary font-bold hover:gap-2 flex items-center gap-1 transition-all">
                        {{ __('landing.projects.view_all') }}
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($relatedPosts as $rPost)
                        <article class="group bg-card border border-border rounded-3xl overflow-hidden hover:shadow-xl transition-all duration-500">
                            <div class="aspect-[16/10] overflow-hidden">
                                <img src="{{ asset('storage/' . $rPost->featured_image) }}" alt="{{ $rPost->getTranslation('title', app()->getLocale()) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            </div>
                            <div class="p-6">
                                <h3 class="font-bold text-lg mb-2 group-hover:text-primary transition-colors line-clamp-2">
                                    <a href="{{ route('blog.show', $rPost->slug) }}" wire:navigate>
                                        {{ $rPost->getTranslation('title', app()->getLocale()) }}
                                    </a>
                                </h3>
                                <p class="text-muted-foreground text-xs font-bold">{{ $rPost->published_at->format('M d, Y') }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <x-sections.cta />
</div>
