<div>
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ __('Stats Section') }}</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('Control all homepage sections from the dashboard') }}</p>
        </div>
        <button wire:click="save"
            class="flex items-center gap-2 bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-bold hover:bg-blue-700 transition-colors">
            <i data-lucide="save" class="w-4 h-4"></i>
            {{ __('Save Changes') }}
        </button>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <x-admin.stat-field label="{{ __('Projects Count') }}"
            count_name="projects_count"
            label_ar_name="projects_label_ar"
            label_en_name="projects_label_en" />
        <x-admin.stat-field label="{{ __('Years Count') }}"
            count_name="years_count"
            label_ar_name="years_label_ar"
            label_en_name="years_label_en" />
        <x-admin.stat-field label="{{ __('Countries Count') }}"
            count_name="countries_count"
            label_ar_name="countries_label_ar"
            label_en_name="countries_label_en" />
        <x-admin.stat-field label="{{ __('Clients Count') }}"
            count_name="clients_count"
            label_ar_name="clients_label_ar"
            label_en_name="clients_label_en" />
    </div>
</div>
