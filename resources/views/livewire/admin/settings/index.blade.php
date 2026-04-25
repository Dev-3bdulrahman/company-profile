<div x-data="{ activeTab: 'general' }">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Manage Settings') }}</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('Customize site identity, SEO and professional configurations') }}</p>
        </div>
        <button wire:click="save"
            class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-200 flex items-center gap-2 group">
            <i data-lucide="save" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
            <span>{{ __('Save Changes') }}</span>
        </button>
    </div>

    <!-- Tabs Navigation -->
    <div class="flex items-center gap-1 bg-gray-100 dark:bg-gray-800 p-1 rounded-xl mb-8 w-fit transition-colors overflow-x-auto max-w-full no-scrollbar">
        <button @click="activeTab = 'general'"
            :class="{ 'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm': activeTab === 'general', 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200': activeTab !== 'general' }"
            class="px-6 py-2 rounded-lg text-sm font-bold transition-all whitespace-nowrap">{{ __('General Settings') }}</button>
        <button @click="activeTab = 'identity'"
            :class="{ 'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm': activeTab === 'identity', 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200': activeTab !== 'identity' }"
            class="px-6 py-2 rounded-lg text-sm font-bold transition-all whitespace-nowrap">{{ __('Site Identity') }}</button>
        <button @click="activeTab = 'seo'"
            :class="{ 'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm': activeTab === 'seo', 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200': activeTab !== 'seo' }"
            class="px-6 py-2 rounded-lg text-sm font-bold transition-all whitespace-nowrap">{{ __('SEO Optimization') }}</button>
        <button @click="activeTab = 'legal'"
            :class="{ 'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm': activeTab === 'legal', 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200': activeTab !== 'legal' }"
            class="px-6 py-2 rounded-lg text-sm font-bold transition-all whitespace-nowrap">{{ __('Legal Pages') }}</button>
        <button @click="activeTab = 'social'"
            :class="{ 'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm': activeTab === 'social', 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200': activeTab !== 'social' }"
            class="px-6 py-2 rounded-lg text-sm font-bold transition-all whitespace-nowrap">{{ __('Social Links') }}</button>
        <button @click="activeTab = 'theme'"
            :class="{ 'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm': activeTab === 'theme', 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200': activeTab !== 'theme' }"
            class="px-6 py-2 rounded-lg text-sm font-bold transition-all whitespace-nowrap">{{ __('Theme Settings') }}</button>
        <button @click="activeTab = 'mail'"
            :class="{ 'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm': activeTab === 'mail', 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200': activeTab !== 'mail' }"
            class="px-6 py-2 rounded-lg text-sm font-bold transition-all whitespace-nowrap">{{ __('Mail Settings') }}</button>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Main Content Area -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- General Settings Tab -->
            <div x-show="activeTab === 'general'"
                class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 transition-colors animate-in fade-in slide-in-from-bottom-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i data-lucide="info" class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
                    {{ __('Basic Information') }}
                </h3>
                <div class="grid gap-6">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Site Name') }} (العربية)</label>
                            <input type="text" wire:model="site_name_ar" dir="rtl"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Site Name') }} (English)</label>
                            <input type="text" wire:model="site_name_en" dir="ltr"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all">
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Brand Tagline') }} (العربية)</label>
                            <input type="text" wire:model="job_title_ar" dir="rtl"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Brand Tagline') }} (English)</label>
                            <input type="text" wire:model="job_title_en" dir="ltr"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all">
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Contact Email') }}</label>
                            <input type="email" wire:model="contact_email"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Contact Phone') }}</label>
                            <input type="text" wire:model="contact_phone"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Identity Settings Tab -->
            <div x-show="activeTab === 'identity'"
                class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 transition-colors animate-in fade-in slide-in-from-bottom-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i data-lucide="image" class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
                    {{ __('Site Identity') }}
                </h3>
                <div class="grid gap-8">
                    <div class="grid md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-4">{{ __('Logo (Light)') }}</label>
                            <div class="relative group">
                                <div class="w-full h-32 rounded-xl bg-gray-50 dark:bg-gray-800 border-2 border-dashed border-gray-200 dark:border-gray-700 flex items-center justify-center overflow-hidden transition-colors">
                                    @if ($logo_light && !is_string($logo_light))
                                        <img src="{{ $logo_light->temporaryUrl() }}" class="max-h-24 object-contain">
                                    @elseif ($existing_logo_light)
                                        <img src="{{ asset('storage/' . $existing_logo_light) }}" class="max-h-24 object-contain">
                                    @else
                                        <i data-lucide="upload-cloud" class="w-8 h-8 text-gray-300"></i>
                                    @endif
                                </div>
                                <input type="file" wire:model="logo_light" class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-4">{{ __('Logo (Dark)') }}</label>
                            <div class="relative group">
                                <div class="w-full h-32 rounded-xl bg-gray-900 border-2 border-dashed border-gray-700 flex items-center justify-center overflow-hidden transition-colors">
                                    @if ($logo_dark && !is_string($logo_dark))
                                        <img src="{{ $logo_dark->temporaryUrl() }}" class="max-h-24 object-contain">
                                    @elseif ($existing_logo_dark)
                                        <img src="{{ asset('storage/' . $existing_logo_dark) }}" class="max-h-24 object-contain">
                                    @else
                                        <i data-lucide="upload-cloud" class="w-8 h-8 text-gray-600"></i>
                                    @endif
                                </div>
                                <input type="file" wire:model="logo_dark" class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-4">{{ __('Favicon') }}</label>
                        <div class="flex items-center gap-6">
                            <div class="w-16 h-16 rounded-lg bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 flex items-center justify-center overflow-hidden transition-colors">
                                @if ($favicon && !is_string($favicon))
                                    <img src="{{ $favicon->temporaryUrl() }}" class="w-10 h-10 object-contain">
                                @elseif ($existing_favicon)
                                    <img src="{{ asset('storage/' . $existing_favicon) }}" class="w-10 h-10 object-contain">
                                @else
                                    <i data-lucide="globe" class="w-8 h-8 text-gray-300"></i>
                                @endif
                            </div>
                            <input type="file" wire:model="favicon" class="text-sm">
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Settings Tab -->
            <div x-show="activeTab === 'seo'"
                class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 transition-colors animate-in fade-in slide-in-from-bottom-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i data-lucide="search" class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
                    {{ __('Professional SEO') }}
                </h3>
                
                <!-- Google Search Preview -->
                <div class="mb-10 p-6 bg-gray-50 dark:bg-gray-800/50 rounded-2xl border border-gray-100 dark:border-gray-700">
                    <h4 class="text-xs font-black text-gray-400 uppercase mb-4 tracking-widest">{{ __('Google Search Preview') }}</h4>
                    <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm max-w-2xl text-left">
                        <div class="flex items-center gap-2 mb-1">
                            <div class="w-7 h-7 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                                <i data-lucide="globe" class="w-4 h-4 text-gray-400"></i>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-900 dark:text-gray-100 leading-tight">{{ $site_name_en ?: 'Site Name' }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 leading-tight">{{ config('app.url') }}</span>
                            </div>
                        </div>
                        <h5 class="text-xl text-blue-700 dark:text-blue-400 font-medium mb-1 hover:underline cursor-pointer">
                            {{ $seo_title_en ?: ($site_name_en ?: 'Professional SEO Title') }}
                        </h5>
                        <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed line-clamp-2">
                            {{ $seo_description_en ?: 'Add a compelling meta description to attract more visitors.' }}
                        </p>
                    </div>
                </div>

                <div class="grid gap-8">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Meta Title') }} (العربية)</label>
                            <input type="text" wire:model="seo_title_ar" dir="rtl" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Meta Title') }} (English)</label>
                            <input type="text" wire:model="seo_title_en" dir="ltr" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all">
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Meta Description') }} (العربية)</label>
                            <textarea wire:model="seo_description_ar" rows="3" dir="rtl" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Meta Description') }} (English)</label>
                            <textarea wire:model="seo_description_en" rows="3" dir="ltr" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all"></textarea>
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 gap-8 pt-8 border-t border-gray-100 dark:border-gray-800">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-4">{{ __('Social Share Image (OG Image)') }}</label>
                            <div class="relative group">
                                <div class="w-full aspect-video rounded-xl bg-gray-50 dark:bg-gray-800 border-2 border-dashed border-gray-200 dark:border-gray-700 flex items-center justify-center overflow-hidden transition-colors">
                                    @if ($og_image && !is_string($og_image))
                                        <img src="{{ $og_image->temporaryUrl() }}" class="w-full h-full object-cover">
                                    @elseif ($existing_og_image)
                                        <img src="{{ asset('storage/' . $existing_og_image) }}" class="w-full h-full object-cover">
                                    @else
                                        <i data-lucide="share-2" class="w-8 h-8 text-gray-300"></i>
                                    @endif
                                </div>
                                <input type="file" wire:model="og_image" class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Google Analytics ID') }}</label>
                                <input type="text" wire:model="google_analytics_id" placeholder="G-XXXXXXXXXX" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Facebook Pixel ID') }}</label>
                                <input type="text" wire:model="facebook_pixel_id" placeholder="XXXXXXXXXXXXXXX" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Legal Pages Tab -->
            <div x-show="activeTab === 'legal'"
                class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 transition-colors animate-in fade-in slide-in-from-bottom-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i data-lucide="file-text" class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
                    {{ __('Legal Pages Content') }}
                </h3>
                
                <div x-data="{ legalLang: 'ar' }" class="space-y-10">

                    {{-- Language Switcher --}}
                    <div class="flex border-b border-gray-100 dark:border-gray-800 -mx-8 px-8 mb-6">
                        <button type="button"
                            wire:click="$set('legal_active_lang', 'ar')"
                            onclick="editorSwitchLang('legal-privacy-editor', 'ar'); editorSwitchLang('legal-terms-editor', 'ar')"
                            class="px-6 py-3 text-sm font-bold transition-colors {{ ($legal_active_lang ?? 'ar') === 'ar' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                            {{ __('Arabic') }}
                        </button>
                        <button type="button"
                            wire:click="$set('legal_active_lang', 'en')"
                            onclick="editorSwitchLang('legal-privacy-editor', 'en'); editorSwitchLang('legal-terms-editor', 'en')"
                            class="px-6 py-3 text-sm font-bold transition-colors {{ ($legal_active_lang ?? 'ar') === 'en' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                            {{ __('English') }}
                        </button>
                    </div>

                    {{-- Privacy Policy --}}
                    <div class="space-y-3">
                        <h4 class="font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <span class="w-1.5 h-5 bg-blue-600 rounded-full"></span>
                            {{ __('Privacy Policy') }}
                        </h4>
                        <div class="tiptap-editor-wrap border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                            <div class="flex flex-wrap gap-1 p-2 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                                @php $btns = [
                                    ['bold','bold'],['italic','italic'],['underline','underline'],['strike','strikethrough'],
                                    ['h2','heading-2'],['h3','heading-3'],['bulletList','list'],['orderedList','list-ordered'],
                                    ['blockquote','quote'],['link','link'],['undo','undo-2'],['redo','redo-2'],
                                    ['alignLeft','align-left'],['alignCenter','align-center'],['alignRight','align-right'],['alignJustify','align-justify'],
                                ]; @endphp
                                @foreach($btns as [$action, $icon])
                                <button type="button"
                                    onmousedown="event.preventDefault(); editorCmd('legal-privacy-editor', '{{ $action }}')"
                                    class="p-1.5 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400 transition-colors">
                                    <i data-lucide="{{ $icon }}" class="w-4 h-4"></i>
                                </button>
                                @endforeach
                            </div>
                            <div wire:ignore id="legal-privacy-editor" class="min-h-[300px] bg-white dark:bg-gray-900"></div>
                        </div>
                        @script
                        <script>
                            initRichEditor(
                                'legal-privacy-editor',
                                '{{ $this->getId() }}',
                                'privacy_policy',
                                null,
                                @json($privacy_policy_ar ?? ''),
                                @json($privacy_policy_en ?? ''),
                                '{{ $legal_active_lang ?? 'ar' }}',
                                true
                            );
                        </script>
                        @endscript
                    </div>

                    {{-- Terms of Service --}}
                    <div class="space-y-3 pt-8 border-t border-gray-100 dark:border-gray-800">
                        <h4 class="font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <span class="w-1.5 h-5 bg-purple-600 rounded-full"></span>
                            {{ __('Terms of Service') }}
                        </h4>
                        <div class="tiptap-editor-wrap border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                            <div class="flex flex-wrap gap-1 p-2 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                                @foreach($btns as [$action, $icon])
                                <button type="button"
                                    onmousedown="event.preventDefault(); editorCmd('legal-terms-editor', '{{ $action }}')"
                                    class="p-1.5 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400 transition-colors">
                                    <i data-lucide="{{ $icon }}" class="w-4 h-4"></i>
                                </button>
                                @endforeach
                            </div>
                            <div wire:ignore id="legal-terms-editor" class="min-h-[300px] bg-white dark:bg-gray-900"></div>
                        </div>
                        @script
                        <script>
                            initRichEditor(
                                'legal-terms-editor',
                                '{{ $this->getId() }}',
                                'terms_of_service',
                                null,
                                @json($terms_of_service_ar ?? ''),
                                @json($terms_of_service_en ?? ''),
                                '{{ $legal_active_lang ?? 'ar' }}',
                                true
                            );
                        </script>
                        @endscript
                    </div>

                </div>
            </div>

            <!-- Social Links Tab -->
            <div x-show="activeTab === 'social'"
                class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 transition-colors animate-in fade-in slide-in-from-bottom-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i data-lucide="share-2" class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
                    {{ __('Social Media Links') }}
                </h3>
                <div class="grid md:grid-cols-2 gap-6">
                    @foreach(['whatsapp', 'facebook', 'instagram', 'linkedin', 'twitter', 'tiktok', 'youtube'] as $social)
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 capitalize">{{ $social }}</label>
                        <input type="text" wire:model="{{ $social }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all">
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Mail Settings Tab -->
            <div x-show="activeTab === 'mail'"
                class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 transition-colors animate-in fade-in slide-in-from-bottom-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
                    <i data-lucide="mail" class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
                    {{ __('Mail Settings') }}
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">{{ __('Configure the outgoing mail server used to send replies to visitors.') }}</p>

                {{-- Mailer Type --}}
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">{{ __('Mail Driver') }}</label>
                    <div class="flex gap-3">
                        @foreach(['smtp' => __('SMTP / Custom'), 'gmail' => __('Gmail (App Password)')] as $val => $label)
                        <label class="flex items-center gap-2 px-4 py-3 rounded-xl border-2 cursor-pointer transition-all {{ $mail_mailer === $val ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-gray-200 dark:border-gray-700' }}">
                            <input type="radio" wire:model.live="mail_mailer" value="{{ $val }}" class="accent-blue-600">
                            <span class="font-bold text-sm text-gray-800 dark:text-gray-200">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                @if($mail_mailer === 'gmail')
                {{-- Gmail Mode --}}
                <div class="p-4 mb-6 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-xl text-sm text-yellow-800 dark:text-yellow-300 flex gap-3">
                    <i data-lucide="info" class="w-5 h-5 shrink-0 mt-0.5"></i>
                    <span>{!! __('Use a <strong>Gmail App Password</strong>, not your regular password. <a href="https://myaccount.google.com/apppasswords" target="_blank" class="underline font-bold">Generate one here</a>.') !!}</span>
                </div>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Gmail Address') }}</label>
                        <input type="email" wire:model="mail_username" placeholder="you@gmail.com"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('App Password') }}</label>
                        <input type="password" wire:model="mail_password" placeholder="xxxx xxxx xxxx xxxx"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('From Name') }}</label>
                        <input type="text" wire:model="mail_from_name"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('From Address') }}</label>
                        <input type="email" wire:model="mail_from_address" placeholder="you@gmail.com"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all">
                    </div>
                </div>
                @else
                {{-- SMTP Mode --}}
                <div class="grid gap-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('SMTP Host') }}</label>
                            <input type="text" wire:model="mail_host" placeholder="smtp.example.com"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('SMTP Port') }}</label>
                            <input type="text" wire:model="mail_port" placeholder="587"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all">
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Username') }}</label>
                            <input type="text" wire:model="mail_username"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Password') }}</label>
                            <input type="password" wire:model="mail_password"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all">
                        </div>
                    </div>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Encryption') }}</label>
                            <select wire:model="mail_encryption"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all">
                                <option value="tls">TLS</option>
                                <option value="ssl">SSL</option>
                                <option value="">{{ __('None') }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('From Name') }}</label>
                            <input type="text" wire:model="mail_from_name"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('From Address') }}</label>
                            <input type="email" wire:model="mail_from_address"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 transition-all">
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Theme Settings Tab -->
            <div x-show="activeTab === 'theme'"
                class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 transition-colors animate-in fade-in slide-in-from-bottom-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i data-lucide="palette" class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
                    {{ __('Theme & Appearance') }}
                </h3>
                <div class="grid gap-6">
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white">{{ __('Dark Mode Support') }}</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="dark_mode_supported" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>
            </div>

        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm transition-colors text-left">
                <h4 class="font-black text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i data-lucide="monitor" class="w-5 h-5 text-blue-600"></i>
                    {{ __('Site Status') }}
                </h4>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800/50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="relative flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $is_online ? 'bg-green-400' : 'bg-red-400' }} opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 {{ $is_online ? 'bg-green-500' : 'bg-red-500' }}"></span>
                            </div>
                            <span class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ __('Visibility') }}</span>
                        </div>
                        <span class="text-xs font-black uppercase {{ $is_online ? 'text-green-600' : 'text-red-600' }}">{{ $is_online ? __('Online') : __('Offline') }}</span>
                    </div>
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl">
                        <p class="text-[10px] uppercase font-black text-blue-600 dark:text-blue-400 mb-1">{{ __('Last Updated') }}</p>
                        <p class="text-sm font-bold text-blue-900 dark:text-blue-200">{{ $last_updated_human }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@tiptap/core@2.4.0/dist/index.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tiptap/starter-kit@2.4.0/dist/index.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tiptap/extension-underline@2.4.0/dist/index.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tiptap/extension-link@2.4.0/dist/index.umd.min.js"></script>
<script>
window.tiptapEditor = function({ content, dir }) {
    return {
        editor: null,
        init() {
            const { Editor } = window['@tiptap/core'];
            const { StarterKit } = window['@tiptap/starter-kit'];
            const { Underline } = window['@tiptap/extension-underline'];
            const { Link } = window['@tiptap/extension-link'];

            this.editor = new Editor({
                element: this.$refs.editorEl,
                extensions: [StarterKit, Underline, Link.configure({ openOnClick: false })],
                content: content,
                onUpdate: ({ editor }) => {
                    this.content = editor.getHTML();
                },
                editorProps: {
                    attributes: {
                        class: 'outline-none min-h-[250px]',
                        dir: dir,
                    }
                }
            });

            this.$watch('content', value => {
                if (value !== this.editor.getHTML()) {
                    this.editor.commands.setContent(value, false);
                }
            });
        }
    }
};
</script>
@endpush