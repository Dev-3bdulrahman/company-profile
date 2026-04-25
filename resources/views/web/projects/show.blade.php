<x-guest-layout>
    <div class="bg-white dark:bg-gray-950 min-h-screen">
        {{-- Hero Section --}}
        <div class="relative h-[60vh] min-h-[400px] overflow-hidden">
            <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->getTranslation('title') }}" 
                 class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent"></div>
            
            <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
                <div class="mb-6 inline-block px-4 py-1 rounded-full bg-primary/20 border border-primary/30 backdrop-blur-md text-primary text-sm font-bold uppercase tracking-widest animate-fade-in-up">
                    {{ $project->year }}
                </div>
                <h1 class="text-4xl md:text-6xl font-black text-white mb-6 drop-shadow-2xl animate-fade-in-up" style="animation-delay: 100ms">
                    {{ $project->getTranslation('title') }}
                </h1>
                <div class="w-20 h-1 bg-primary rounded-full animate-fade-in-up" style="animation-delay: 200ms"></div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-16">
                {{-- Main Content --}}
                <div class="lg:col-span-2">
                    <div class="mb-12">
                        <h2 class="text-3xl font-black mb-8 border-l-4 border-primary pl-6 rtl:border-l-0 rtl:border-r-4 rtl:pr-6">
                            {{ __('About the Project') }}
                        </h2>
                        <div class="prose prose-lg dark:prose-invert max-w-none 
                                    text-gray-600 dark:text-gray-400 leading-relaxed font-medium">
                            {!! nl2br(e($project->getTranslation('description'))) !!}
                        </div>
                    </div>

                    {{-- Gallery --}}
                    @if($project->gallery && count($project->gallery) > 0)
                    <div class="mt-20">
                        <h2 class="text-3xl font-black mb-8 border-l-4 border-primary pl-6 rtl:border-l-0 rtl:border-r-4 rtl:pr-6">
                            {{ __('Project Gallery') }}
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            @foreach($project->gallery as $image)
                            <div class="group relative aspect-[4/3] rounded-2xl overflow-hidden bg-gray-100 dark:bg-gray-900 shadow-xl shadow-black/5">
                                <img src="{{ asset('storage/' . $image) }}" 
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6"/><path d="M9 21H3v-6"/><path d="M21 3l-7 7"/><path d="M3 21l7-7"/></svg>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-32 space-y-8">
                        {{-- Project Info Card --}}
                        <div class="bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-800 rounded-3xl p-8 shadow-sm">
                            <h3 class="text-xl font-black mb-6">{{ __('Project Details') }}</h3>
                            <div class="space-y-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Completion Year') }}</div>
                                        <div class="text-lg font-black">{{ $project->year }}</div>
                                    </div>
                                </div>

                                @if($project->behance_url)
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-[#0057ff]/10 flex items-center justify-center text-[#0057ff]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 13H5V9h4v4z"/><path d="M15 13h-4V9h4v4z"/><path d="M20 9.5h-2.5c-.3 0-.5.2-.5.5v3.5c0 .3.2.5.5.5H20c.3 0 .5-.2.5-.5V10c0-.3-.2-.5-.5-.5z"/><path d="M15 13H5V9h10v4z"/><path d="M15 5H5c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2z"/></svg>
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('View on Behance') }}</div>
                                        <a href="{{ $project->behance_url }}" target="_blank" class="text-lg font-black text-primary hover:underline">{{ __('Open Project') }}</a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- CTA --}}
                        <div class="bg-primary rounded-3xl p-8 text-primary-foreground shadow-xl shadow-primary/20 overflow-hidden relative group">
                            <div class="absolute -right-4 -bottom-4 w-32 h-32 bg-white/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                            <h3 class="text-2xl font-black mb-4 relative z-10">{{ __('Inspired by this work?') }}</h3>
                            <p class="mb-8 opacity-90 font-medium relative z-10">{{ __('Let us help you build your dream sports facility with the same quality and dedication.') }}</p>
                            <a href="{{ route('contact') }}" class="block w-full text-center bg-white text-primary font-black py-4 px-6 rounded-2xl hover:bg-gray-100 transition-all active:scale-95 relative z-10 shadow-lg">
                                {{ __('Start Your Project') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
