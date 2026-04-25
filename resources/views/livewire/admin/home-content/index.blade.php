<div>
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ __('Manage Home Content') }}</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ __('Control all homepage sections from the dashboard') }}</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" target="_blank"
               class="flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                <i data-lucide="external-link" class="w-4 h-4"></i>
                {{ __('Preview Site') }}
            </a>
            <button wire:click="save"
                    class="flex items-center gap-2 bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-bold hover:bg-blue-700 transition-colors">
                <i data-lucide="save" class="w-4 h-4"></i>
                {{ __('Save All') }}
            </button>
        </div>
    </div>

    {{-- Section Cards Grid --}}
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

        @php
            $sectionCards = [
                [
                    'tab'   => 'hero',
                    'icon'  => 'layout-template',
                    'color' => 'blue',
                    'label' => __('Hero Section'),
                    'desc'  => $hero_title1_ar . ' / ' . $hero_title1_en,
                    'fields' => [
                        ['label' => __('Eyebrow Text'),          'ar' => 'hero_eyebrow_ar',  'en' => 'hero_eyebrow_en'],
                        ['label' => __('Title Line 1'),          'ar' => 'hero_title1_ar',   'en' => 'hero_title1_en'],
                        ['label' => __('Title Line 2 (Gradient)'), 'ar' => 'hero_title2_ar', 'en' => 'hero_title2_en'],
                        ['label' => __('Button 1 Text'),         'ar' => 'hero_cta1_ar',     'en' => 'hero_cta1_en'],
                        ['label' => __('Button 2 Text'),         'ar' => 'hero_cta2_ar',     'en' => 'hero_cta2_en'],
                        ['label' => __('Subtitle'),              'ar' => 'hero_subtitle_ar', 'en' => 'hero_subtitle_en', 'type' => 'textarea'],
                    ],
                ],
                [
                    'tab'   => 'stats',
                    'icon'  => 'bar-chart-2',
                    'color' => 'green',
                    'label' => __('Stats Section'),
                    'desc'  => $stats_projects_count . ' · ' . $stats_years_count . ' · ' . $stats_countries_count . ' · ' . $stats_clients_count,
                ],
                [
                    'tab'   => 'services',
                    'icon'  => 'briefcase',
                    'color' => 'purple',
                    'label' => __('Services Section'),
                    'desc'  => $services_title_ar ?: $services_title_en,
                    'fields' => [
                        ['label' => __('Eyebrow Text'),    'ar' => 'services_eyebrow_ar',  'en' => 'services_eyebrow_en'],
                        ['label' => __('Section Title'),   'ar' => 'services_title_ar',    'en' => 'services_title_en'],
                        ['label' => __('Section Subtitle'),'ar' => 'services_subtitle_ar', 'en' => 'services_subtitle_en', 'type' => 'textarea'],
                    ],
                    'link' => ['route' => 'admin.services', 'label' => __('Manage Services')],
                ],
                [
                    'tab'   => 'process',
                    'icon'  => 'list-checks',
                    'color' => 'amber',
                    'label' => __('Process Section'),
                    'desc'  => $process_title_ar ?: $process_title_en,
                    'fields' => [
                        ['label' => __('Eyebrow Text'),  'ar' => 'process_eyebrow_ar', 'en' => 'process_eyebrow_en'],
                        ['label' => __('Section Title'), 'ar' => 'process_title_ar',   'en' => 'process_title_en'],
                    ],
                    'link' => ['route' => 'admin.process_steps', 'label' => __('Manage Process Steps')],
                ],
                [
                    'tab'   => 'projects',
                    'icon'  => 'layers',
                    'color' => 'orange',
                    'label' => __('Projects Section'),
                    'desc'  => $projects_title_ar ?: $projects_title_en,
                    'fields' => [
                        ['label' => __('Eyebrow Text'),    'ar' => 'projects_eyebrow_ar',  'en' => 'projects_eyebrow_en'],
                        ['label' => __('Section Title'),   'ar' => 'projects_title_ar',    'en' => 'projects_title_en'],
                        ['label' => __('Section Subtitle'),'ar' => 'projects_subtitle_ar', 'en' => 'projects_subtitle_en', 'type' => 'textarea'],
                    ],
                    'link' => ['route' => 'admin.portfolio', 'label' => __('Manage Portfolio')],
                ],
                [
                    'tab'   => 'testimonials',
                    'icon'  => 'message-square-quote',
                    'color' => 'pink',
                    'label' => __('Testimonials Section'),
                    'desc'  => $test_title_ar ?: $test_title_en,
                    'fields' => [
                        ['label' => __('Eyebrow Text'),  'ar' => 'test_eyebrow_ar', 'en' => 'test_eyebrow_en'],
                        ['label' => __('Section Title'), 'ar' => 'test_title_ar',   'en' => 'test_title_en'],
                    ],
                    'link' => ['route' => 'admin.testimonials', 'label' => __('Manage Testimonials')],
                ],
                [
                    'tab'   => 'cta',
                    'icon'  => 'megaphone',
                    'color' => 'indigo',
                    'label' => __('CTA Section'),
                    'desc'  => $cta_title_ar ?: $cta_title_en,
                    'fields' => [
                        ['label' => __('Section Title'),   'ar' => 'cta_title_ar',    'en' => 'cta_title_en'],
                        ['label' => __('CTA Button Text'), 'ar' => 'cta_button_ar',   'en' => 'cta_button_en'],
                        ['label' => __('Section Subtitle'),'ar' => 'cta_subtitle_ar', 'en' => 'cta_subtitle_en', 'type' => 'textarea'],
                    ],
                ],
            ];
        @endphp

        @foreach($sectionCards as $card)
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden hover:shadow-md transition-shadow group">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-{{ $card['color'] }}-50 dark:bg-{{ $card['color'] }}-900/20 flex items-center justify-center text-{{ $card['color'] }}-600 dark:text-{{ $card['color'] }}-400 group-hover:scale-110 transition-transform">
                        <i data-lucide="{{ $card['icon'] }}" class="w-6 h-6"></i>
                    </div>
                    <button wire:click="$set('activeTab', '{{ $card['tab'] }}')"
                            class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors"
                            title="{{ __('Edit') }}">
                        <i data-lucide="pencil" class="w-4 h-4"></i>
                    </button>
                </div>
                <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 mb-1">{{ $card['label'] }}</h3>
                <p class="text-gray-400 dark:text-gray-500 text-sm line-clamp-1">{{ $card['desc'] }}</p>

                @if(isset($card['link']))
                <div class="mt-4 pt-4 border-t border-gray-50 dark:border-gray-800">
                    <a href="{{ route($card['link']['route']) }}" wire:navigate
                       class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 hover:underline">
                        <i data-lucide="arrow-up-right" class="w-3.5 h-3.5"></i>
                        {{ $card['link']['label'] }}
                    </a>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    {{-- Edit Modal --}}
    <div x-data="{ open: @entangle('activeTab').live !== '' }"
         x-show="$wire.activeTab !== ''"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="relative flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="$wire.activeTab !== ''"
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 @click="$wire.set('activeTab', '')"
                 class="absolute inset-0 bg-gray-500/75 transition-opacity"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div x-show="$wire.activeTab !== ''"
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
                 class="inline-block align-middle bg-white dark:bg-gray-900 rounded-xl text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-2xl w-full">

                {{-- Modal Header --}}
                <div class="bg-white dark:bg-gray-900 px-6 py-5 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                        @if($activeTab === 'hero')          {{ __('Hero Section') }}
                        @elseif($activeTab === 'stats')     {{ __('Stats Section') }}
                        @elseif($activeTab === 'services')  {{ __('Services Section') }}
                        @elseif($activeTab === 'process')   {{ __('Process Section') }}
                        @elseif($activeTab === 'projects')  {{ __('Projects Section') }}
                        @elseif($activeTab === 'testimonials') {{ __('Testimonials Section') }}
                        @elseif($activeTab === 'cta')       {{ __('CTA Section') }}
                        @endif
                    </h3>
                    <button wire:click="$set('activeTab', '')" type="button" class="text-gray-400 hover:text-gray-500">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>

                {{-- Modal Body --}}
                <div class="px-6 py-6 space-y-5 max-h-[70vh] overflow-y-auto">

                    {{-- Hero --}}
                    @if($activeTab === 'hero')
                        @foreach([
                            ['label' => __('Eyebrow Text'),            'ar' => 'hero_eyebrow_ar',  'en' => 'hero_eyebrow_en'],
                            ['label' => __('Title Line 1'),            'ar' => 'hero_title1_ar',   'en' => 'hero_title1_en'],
                            ['label' => __('Title Line 2 (Gradient)'), 'ar' => 'hero_title2_ar',   'en' => 'hero_title2_en'],
                            ['label' => __('Button 1 Text'),           'ar' => 'hero_cta1_ar',     'en' => 'hero_cta1_en'],
                            ['label' => __('Button 2 Text'),           'ar' => 'hero_cta2_ar',     'en' => 'hero_cta2_en'],
                            ['label' => __('Subtitle'),                'ar' => 'hero_subtitle_ar', 'en' => 'hero_subtitle_en', 'type' => 'textarea'],
                        ] as $f)
                            <x-admin.bilingual-field :label="$f['label']" :name_ar="$f['ar']" :name_en="$f['en']" :type="$f['type'] ?? 'input'" />
                        @endforeach
                    @endif

                    {{-- Stats --}}
                    @if($activeTab === 'stats')
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <x-admin.stat-field label="{{ __('Projects Count') }}"
                            count_name="stats_projects_count" :count_value="$stats_projects_count"
                            label_ar_name="stats_projects_label_ar" :label_ar_value="$stats_projects_label_ar"
                            label_en_name="stats_projects_label_en" :label_en_value="$stats_projects_label_en" />
                        <x-admin.stat-field label="{{ __('Years Count') }}"
                            count_name="stats_years_count" :count_value="$stats_years_count"
                            label_ar_name="stats_years_label_ar" :label_ar_value="$stats_years_label_ar"
                            label_en_name="stats_years_label_en" :label_en_value="$stats_years_label_en" />
                        <x-admin.stat-field label="{{ __('Countries Count') }}"
                            count_name="stats_countries_count" :count_value="$stats_countries_count"
                            label_ar_name="stats_countries_label_ar" :label_ar_value="$stats_countries_label_ar"
                            label_en_name="stats_countries_label_en" :label_en_value="$stats_countries_label_en" />
                        <x-admin.stat-field label="{{ __('Clients Count') }}"
                            count_name="stats_clients_count" :count_value="$stats_clients_count"
                            label_ar_name="stats_clients_label_ar" :label_ar_value="$stats_clients_label_ar"
                            label_en_name="stats_clients_label_en" :label_en_value="$stats_clients_label_en" />
                    </div>
                    @endif

                    {{-- Services --}}
                    @if($activeTab === 'services')
                        @foreach([
                            ['label' => __('Eyebrow Text'),    'ar' => 'services_eyebrow_ar',  'en' => 'services_eyebrow_en'],
                            ['label' => __('Section Title'),   'ar' => 'services_title_ar',    'en' => 'services_title_en'],
                            ['label' => __('Section Subtitle'),'ar' => 'services_subtitle_ar', 'en' => 'services_subtitle_en', 'type' => 'textarea'],
                        ] as $f)
                            <x-admin.bilingual-field :label="$f['label']" :name_ar="$f['ar']" :name_en="$f['en']" :type="$f['type'] ?? 'input'" />
                        @endforeach
                    @endif

                    {{-- Process --}}
                    @if($activeTab === 'process')
                        @foreach([
                            ['label' => __('Eyebrow Text'),  'ar' => 'process_eyebrow_ar', 'en' => 'process_eyebrow_en'],
                            ['label' => __('Section Title'), 'ar' => 'process_title_ar',   'en' => 'process_title_en'],
                        ] as $f)
                            <x-admin.bilingual-field :label="$f['label']" :name_ar="$f['ar']" :name_en="$f['en']" />
                        @endforeach
                    @endif

                    {{-- Projects --}}
                    @if($activeTab === 'projects')
                        @foreach([
                            ['label' => __('Eyebrow Text'),    'ar' => 'projects_eyebrow_ar',  'en' => 'projects_eyebrow_en'],
                            ['label' => __('Section Title'),   'ar' => 'projects_title_ar',    'en' => 'projects_title_en'],
                            ['label' => __('Section Subtitle'),'ar' => 'projects_subtitle_ar', 'en' => 'projects_subtitle_en', 'type' => 'textarea'],
                        ] as $f)
                            <x-admin.bilingual-field :label="$f['label']" :name_ar="$f['ar']" :name_en="$f['en']" :type="$f['type'] ?? 'input'" />
                        @endforeach
                    @endif

                    {{-- Testimonials --}}
                    @if($activeTab === 'testimonials')
                        @foreach([
                            ['label' => __('Eyebrow Text'),  'ar' => 'test_eyebrow_ar', 'en' => 'test_eyebrow_en'],
                            ['label' => __('Section Title'), 'ar' => 'test_title_ar',   'en' => 'test_title_en'],
                        ] as $f)
                            <x-admin.bilingual-field :label="$f['label']" :name_ar="$f['ar']" :name_en="$f['en']" />
                        @endforeach
                    @endif

                    {{-- CTA --}}
                    @if($activeTab === 'cta')
                        @foreach([
                            ['label' => __('Section Title'),   'ar' => 'cta_title_ar',    'en' => 'cta_title_en'],
                            ['label' => __('CTA Button Text'), 'ar' => 'cta_button_ar',   'en' => 'cta_button_en'],
                            ['label' => __('Section Subtitle'),'ar' => 'cta_subtitle_ar', 'en' => 'cta_subtitle_en', 'type' => 'textarea'],
                        ] as $f)
                            <x-admin.bilingual-field :label="$f['label']" :name_ar="$f['ar']" :name_en="$f['en']" :type="$f['type'] ?? 'input'" />
                        @endforeach
                    @endif
                </div>

                {{-- Modal Footer --}}
                <div class="bg-gray-50 dark:bg-gray-800/50 px-6 py-4 flex flex-row-reverse gap-3">
                    <button wire:click="save"
                            class="inline-flex justify-center rounded-lg px-6 py-2 bg-blue-600 text-sm font-bold text-white hover:bg-blue-700 transition-colors">
                        {{ __('Save Changes') }}
                    </button>
                    <button wire:click="$set('activeTab', '')" type="button"
                            class="inline-flex justify-center rounded-lg border border-gray-300 dark:border-gray-600 px-4 py-2 bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        {{ __('Cancel') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
