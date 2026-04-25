<div class="p-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black">{{ __('Visitor Logs') }}</h1>
            <p class="text-muted-foreground mt-1">{{ __('Track every visit to your website in real-time.') }}</p>
        </div>
        <div class="flex items-center gap-3">
            <button wire:click="$dispatch('swal:confirm', { 
                        title: 'Clear Logs',
                        text: 'Are you sure you want to clear all visitor logs?',
                        onConfirm: 'clearLogs'
                    })"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-800 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors font-bold text-sm">
                <i data-lucide="trash-2" class="w-4 h-4"></i>
                <span>{{ __('Clear Logs') }}</span>
            </button>
        </div>
    </div>

    <div class="surface-card rounded-2xl border border-border overflow-hidden">
        <div class="p-4 border-b border-border bg-muted/30">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="relative flex-1">
                    <i data-lucide="search" class="absolute start-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground"></i>
                    <input type="text" wire:model.live.debounce.300ms="search" 
                           placeholder="{{ __('Search by IP, URL, or Location...') }}"
                           class="w-full ps-10 pe-4 py-2 rounded-xl border-border bg-background focus:ring-primary">
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-start">
                <thead class="bg-muted/50 text-xs uppercase tracking-wider font-bold">
                    <tr>
                        <th class="px-6 py-4">{{ __('Visitor') }}</th>
                        <th class="px-6 py-4">{{ __('Location') }}</th>
                        <th class="px-6 py-4">{{ __('Page') }}</th>
                        <th class="px-6 py-4">{{ __('Language') }}</th>
                        <th class="px-6 py-4">{{ __('Device') }}</th>
                        <th class="px-6 py-4">{{ __('Date') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($logs as $log)
                    <tr class="hover:bg-muted/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-mono text-sm">{{ $log->ip_address }}</span>
                                <span class="text-xs text-muted-foreground">{{ $log->is_unique ? __('Unique Visit') : __('Returning Visit') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-medium">{{ $log->city }}, {{ $log->country }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col max-w-[200px]">
                                <span class="text-xs text-primary truncate" title="{{ $log->url }}">
                                    {{ Str::after($log->url, config('app.url')) ?: '/' }}
                                </span>
                                @if($log->referrer)
                                <span class="text-[10px] text-muted-foreground truncate" title="{{ $log->referrer }}">
                                    {{ __('Ref:') }} {{ Str::limit($log->referrer, 30) }}
                                </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-md bg-secondary text-[10px] font-bold uppercase">
                                {{ $log->locale ?? __('N/A') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2 text-xs">
                                <i data-lucide="{{ strtolower($log->device_type) == 'mobile' ? 'smartphone' : (strtolower($log->device_type) == 'tablet' ? 'tablet' : 'monitor') }}" class="w-4 h-4"></i>
                                <span>{{ $log->browser }} ({{ $log->platform }})</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-xs text-muted-foreground">
                            {{ $log->created_at->diffForHumans() }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-muted-foreground">
                            <i data-lucide="info" class="w-12 h-12 mx-auto mb-4 opacity-20"></i>
                            <p>{{ __('No visitor logs found matching your criteria.') }}</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-border">
            {{ $logs->links() }}
        </div>
    </div>
</div>
