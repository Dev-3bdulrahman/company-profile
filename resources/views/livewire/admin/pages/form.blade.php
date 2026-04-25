<div>
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.pages') }}" wire:navigate
               class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                <i data-lucide="arrow-right" class="w-5 h-5 rtl:rotate-0 ltr:rotate-180"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $page_id ? __('Edit Page') : __('Add Page') }}
                </h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('Manage page content and settings') }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button wire:click="save"
                class="flex items-center gap-2 bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-bold hover:bg-blue-700 transition-colors">
                <i data-lucide="save" class="w-4 h-4"></i>
                {{ __('Save Page') }}
            </button>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
                <div class="flex border-b border-gray-100 dark:border-gray-800">
                    <button wire:click="$set('active_lang', 'ar')"
                        onclick="editorSwitchLang('page-editor', 'ar')"
                        class="flex-1 px-6 py-3 text-sm font-bold transition-colors {{ $active_lang === 'ar' ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                        {{ __('Arabic') }}
                    </button>
                    <button wire:click="$set('active_lang', 'en')"
                        onclick="editorSwitchLang('page-editor', 'en')"
                        class="flex-1 px-6 py-3 text-sm font-bold transition-colors {{ $active_lang === 'en' ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                        {{ __('English') }}
                    </button>
                </div>

                <div class="p-6 space-y-4">
                    {{-- Title --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Page Title') }}</label>
                        @if($active_lang === 'ar')
                        <input wire:model="title.ar" type="text" dir="rtl" placeholder="{{ __('Page title in Arabic') }}"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-lg font-bold focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                        @else
                        <input wire:model.live="title.en" type="text" dir="ltr" placeholder="{{ __('Page title in English') }}"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-lg font-bold focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                        @endif
                        @error('title.' . $active_lang) <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Rich Text Editor --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Page Content') }}</label>

                        <div class="tiptap-editor-wrap border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                            {{-- Toolbar --}}
                            <div class="flex flex-wrap gap-1 p-2 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                                @php $btns = [
                                    ['bold','bold'],['italic','italic'],['underline','underline'],['strike','strikethrough'],
                                    ['h2','heading-2'],['h3','heading-3'],['bulletList','list'],['orderedList','list-ordered'],
                                    ['blockquote','quote'],['link','link'],['undo','undo-2'],['redo','redo-2'],
                                    ['alignLeft','align-left'],['alignCenter','align-center'],['alignRight','align-right'],['alignJustify','align-justify'],
                                ]; @endphp
                                @foreach($btns as [$action, $icon])
                                <button type="button"
                                    onmousedown="event.preventDefault(); editorCmd('page-editor', '{{ $action }}')"
                                    class="p-1.5 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400 transition-colors"
                                    title="{{ $action }}">
                                    <i data-lucide="{{ $icon }}" class="w-4 h-4"></i>
                                </button>
                                @endforeach



                                <button type="button"
                                    onmousedown="event.preventDefault(); document.getElementById('page-img-input').click()"
                                    class="p-1.5 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400 transition-colors"
                                    title="{{ __('Insert Image') }}">
                                    <i data-lucide="image" class="w-4 h-4"></i>
                                </button>
                                <input type="file" id="page-img-input" class="hidden" accept="image/*"
                                    onchange="editorUploadImg('page-editor', this.files[0]); this.value=''">
                            </div>

                            {{-- Editor Container --}}
                            <div wire:ignore id="page-editor" class="min-h-[400px] bg-white dark:bg-gray-900"></div>
                        </div>

                        @script
                        <script>
                            initRichEditor(
                                'page-editor',
                                '{{ $this->getId() }}',
                                'content',
                                '{{ route('admin.editor.upload_image') }}',
                                @json($content['ar'] ?? ''),
                                @json($content['en'] ?? ''),
                                '{{ $active_lang }}'
                            );
                        </script>
                        @endscript
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Page Settings --}}
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
                <div class="p-5 border-b border-gray-50 dark:border-gray-800 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center">
                        <i data-lucide="settings-2" class="w-4 h-4 text-purple-600"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-gray-100 text-sm">{{ __('Page Settings') }}</h3>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 tracking-wider mb-1.5">{{ __('slug') }}</label>
                        <input wire:model="slug" type="text" dir="ltr" placeholder="page-url-slug"
                            class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none font-medium">
                        @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">{{ __('Order') }}</label>
                        <input wire:model="sort_order" type="number"
                            class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none font-medium">
                    </div>
                    <div class="flex items-center gap-3 pt-2">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="is_active" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        </label>
                        <span class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ __('Activate Page') }}</span>
                    </div>
                </div>
            </div>

            {{-- Featured Image --}}
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
                <div class="p-5 border-b border-gray-50 dark:border-gray-800 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center">
                        <i data-lucide="image" class="w-4 h-4 text-blue-600"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-gray-100 text-sm">{{ __('Cover Image') }}</h3>
                </div>
                <div class="p-5">
                    <div class="aspect-video rounded-lg border-2 border-dashed border-gray-200 dark:border-gray-700 overflow-hidden flex items-center justify-center bg-gray-50 dark:bg-gray-800 mb-3">
                        @if($featured_image)
                            <img src="{{ $featured_image->temporaryUrl() }}" class="w-full h-full object-contain">
                        @elseif($existing_featured_image)
                            <img src="{{ asset('storage/' . $existing_featured_image) }}" class="w-full h-full object-contain">
                        @else
                            <div class="text-center text-gray-400">
                                <i data-lucide="image" class="w-10 h-10 mx-auto mb-2 opacity-30"></i>
                                <p class="text-xs">{{ __('No image selected') }}</p>
                            </div>
                        @endif
                    </div>
                    <input type="file" wire:model="featured_image" id="page-cover" accept="image/*" class="hidden">
                    <label for="page-cover"
                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 cursor-pointer transition-all">
                        <i data-lucide="upload" class="w-4 h-4"></i>
                        {{ __('Choose Image') }}
                    </label>
                    <div wire:loading wire:target="featured_image" class="mt-2 text-xs text-blue-600 text-center">{{ __('Uploading...') }}</div>
                    @error('featured_image') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
    </div>
</div>
