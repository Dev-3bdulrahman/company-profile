<x-guest-layout>
    <div class="py-12 bg-gray-50 dark:bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white sm:text-5xl">
                    {{ __('Our Specialized Services') }}
                </h1>
                <p class="mt-4 text-xl text-gray-600 dark:text-gray-400">
                    {{ __('Providing top-tier construction and maintenance for sports facilities.') }}
                </p>
            </div>

            <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
                @foreach($services as $service)
                    <div class="group relative bg-white dark:bg-gray-900 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-800">
                        <div class="aspect-w-16 aspect-h-9 bg-gray-200 group-hover:opacity-75 transition-opacity duration-300">
                            @if($service->hero_image)
                                <img src="{{ asset('storage/' . $service->hero_image) }}" alt="{{ $service->title[app()->getLocale()] ?? reset($service->title) }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                                    <span class="text-white text-4xl font-bold opacity-20">{{ substr($service->slug, 0, 2) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                <a href="{{ route('services.show', $service->slug) }}">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    {{ $service->title[app()->getLocale()] ?? reset($service->title) }}
                                </a>
                            </h3>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 line-clamp-2">
                                {{ $service->short_description[app()->getLocale()] ?? reset($service->short_description) }}
                            </p>
                            <div class="mt-4 flex items-center text-blue-600 dark:text-blue-400 font-semibold group-hover:translate-x-2 transition-transform duration-300">
                                {{ __('Learn More') }}
                                <svg class="ml-2 w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-guest-layout>
