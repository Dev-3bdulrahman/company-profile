<x-guest-layout>
    <div class="bg-white dark:bg-gray-950 min-h-screen">
        <!-- Hero Section -->
        <div class="relative h-[60vh] min-h-[400px]">
            @if($service->hero_image)
                <img src="{{ asset('storage/' . $service->hero_image) }}" class="absolute inset-0 w-full h-full object-cover">
            @else
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-700"></div>
            @endif
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
            <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
                <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-4 animate-fade-in-up">
                    {{ $service->title[app()->getLocale()] ?? reset($service->title) }}
                </h1>
                <p class="text-xl text-gray-200 max-w-2xl">
                    {{ $service->short_description[app()->getLocale()] ?? reset($service->short_description) }}
                </p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <div class="prose prose-lg dark:prose-invert max-w-none">
                        {!! nl2br(e($service->description[app()->getLocale()] ?? reset($service->description))) !!}
                    </div>

                    @if($service->features)
                        <div class="mt-12">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">{{ __('Key Features') }}</h2>
                            <ul class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($service->features as $feature)
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0 p-1 bg-green-100 dark:bg-green-900 rounded-full text-green-600 dark:text-green-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                        <p class="ml-3 text-gray-700 dark:text-gray-300">
                                            {{ $feature[app()->getLocale()] ?? reset($feature) }}
                                        </p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($service->gallery)
                        <div class="mt-16">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">{{ __('Gallery') }}</h2>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($service->gallery as $image)
                                    <div class="aspect-square rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow duration-300">
                                        <img src="{{ asset('storage/' . $image) }}" class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($service->faqs)
                        <div class="mt-16">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">{{ __('Frequently Asked Questions') }}</h2>
                            <div class="space-y-4">
                                @foreach($service->faqs as $faq)
                                    <div x-data="{ open: false }" class="border border-gray-200 dark:border-gray-800 rounded-xl overflow-hidden">
                                        <button @click="open = !open" class="w-full flex justify-between items-center p-4 text-left font-semibold text-gray-900 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-900 transition">
                                            <span>{{ $faq['question'][app()->getLocale()] ?? reset($faq['question']) }}</span>
                                            <svg :class="{'rotate-180': open}" class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </button>
                                        <div x-show="open" x-cloak class="p-4 bg-gray-50 dark:bg-gray-900 text-gray-600 dark:text-gray-400">
                                            {{ $faq['answer'][app()->getLocale()] ?? reset($faq['answer']) }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="sticky top-24 space-y-8">
                        <!-- CTA Block -->
                        <div class="bg-blue-600 rounded-2xl p-8 text-white shadow-xl shadow-blue-500/20">
                            <h3 class="text-2xl font-bold mb-4">{{ $service->cta_text[app()->getLocale()] ?? __('Ready to Start?') }}</h3>
                            <p class="mb-6 opacity-90">{{ __('Contact us today for a free consultation and quote for your facility.') }}</p>
                            <a href="{{ $service->cta_url ?: route('contact') }}" class="block w-full text-center bg-white text-blue-600 font-bold py-3 px-6 rounded-xl hover:bg-gray-100 transition duration-300">
                                {{ $service->cta_button_text[app()->getLocale()] ?? __('Contact Us') }}
                            </a>
                        </div>

                        <!-- Related Projects -->
                        @if($relatedProjects->count() > 0)
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-2xl p-6 border border-gray-100 dark:border-gray-800">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('Related Projects') }}</h3>
                                <div class="space-y-4">
                                    @foreach($relatedProjects as $project)
                                        <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                            <div class="w-16 h-16 rounded-lg bg-gray-200 overflow-hidden flex-shrink-0">
                                                {{-- Assume projects have an image --}}
                                                <div class="w-full h-full bg-blue-100 flex items-center justify-center text-blue-500 font-bold">P</div>
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-bold text-gray-900 dark:text-white">{{ $project->name }}</h4>
                                                <p class="text-xs text-gray-500">{{ $project->location }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
