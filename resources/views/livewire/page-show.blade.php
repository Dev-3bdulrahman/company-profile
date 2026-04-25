<div>
    {{-- Page Hero --}}
    <section class="relative pt-32 pb-20 overflow-hidden bg-gray-50 dark:bg-gray-900/50">
        <div class="absolute inset-0 z-0">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/5 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-blue-500/5 rounded-full blur-[120px] translate-y-1/2 -translate-x-1/2"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl">
                <nav class="flex items-center gap-2 text-sm font-bold text-primary mb-6" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" class="hover:underline">الرئيسية</a>
                    <i data-lucide="chevron-left" class="w-4 h-4 rtl:block hidden"></i>
                    <i data-lucide="chevron-right" class="w-4 h-4 ltr:block hidden"></i>
                    <span class="text-gray-400">{{ $page->getTranslation('title') }}</span>
                </nav>
                <h1 class="text-4xl md:text-5xl font-black text-gray-900 dark:text-white leading-tight mb-6">
                    {{ $page->getTranslation('title') }}
                </h1>
            </div>
        </div>
    </section>

    {{-- Content --}}
    <section class="py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="prose prose-lg dark:prose-invert max-w-none 
                        prose-headings:font-black prose-headings:text-gray-900 dark:prose-headings:text-white
                        prose-p:text-gray-600 dark:prose-p:text-gray-400 prose-p:leading-relaxed
                        prose-strong:text-gray-900 dark:prose-strong:text-white
                        prose-ul:list-disc prose-li:marker:text-primary">
                {!! $page->getTranslation('content') !!}
            </div>
        </div>
    </section>
</div>
