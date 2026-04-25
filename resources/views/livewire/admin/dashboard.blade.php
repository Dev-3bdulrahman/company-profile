<div>
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $cards = [
                ['key' => 'services',      'label' => __('Services'),        'icon' => 'briefcase', 'color' => 'blue'],
                ['key' => 'portfolio',     'label' => __('Portfolio'),        'icon' => 'layers',    'color' => 'orange'],
                ['key' => 'visitors_today','label' => __('Visitors Today'),   'icon' => 'eye',       'color' => 'green'],
                ['key' => 'unique_today',  'label' => __('Unique Visitors'),  'icon' => 'fingerprint','color' => 'purple'],
            ];
        @endphp

        @foreach($cards as $card)
        <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-{{ $card['color'] }}-50 dark:bg-{{ $card['color'] }}-900/20 flex items-center justify-center text-{{ $card['color'] }}-600 dark:text-{{ $card['color'] }}-400 group-hover:scale-110 transition-transform">
                    <i data-lucide="{{ $card['icon'] }}" class="w-6 h-6"></i>
                </div>
                @if(isset($stats[$card['key']]['trend']) && $stats[$card['key']]['trend'] != 0)
                <span class="text-xs font-bold px-2 py-1 rounded-full {{ $stats[$card['key']]['trend'] > 0 ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50' }}">
                    {{ $stats[$card['key']]['trend'] > 0 ? '+' : '' }}{{ $stats[$card['key']]['trend'] }}%
                </span>
                @endif
            </div>
            <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium">{{ $card['label'] }}</h3>
            <p class="text-3xl font-black text-gray-900 dark:text-white mt-1">
                {{ number_format($stats[$card['key']]['count'] ?? $stats[$card['key']] ?? 0) }}
            </p>
        </div>
        @endforeach
    </div>

    <div class="mt-8 grid lg:grid-cols-3 gap-8">
        {{-- Recent Activity --}}
        <div class="lg:col-span-2 bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-8">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-xl font-black text-gray-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="zap" class="w-6 h-6 text-yellow-500"></i>
                    {{ __('Recent System Activity') }}
                </h3>
                <button wire:click="toggleAllActivity" class="text-sm text-blue-600 hover:underline font-bold">
                    {{ __('View All History') }}
                </button>
            </div>
            <div class="space-y-4">
                @forelse($recentActivity as $activity)
                <div class="flex items-start gap-4 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-2xl border border-transparent hover:border-gray-200 dark:hover:border-gray-700 transition-all group">
                    <div class="mt-1 w-10 h-10 rounded-xl bg-white dark:bg-gray-900 shadow-sm flex items-center justify-center shrink-0">
                        <i data-lucide="{{ $activity['type'] === 'Service' ? 'briefcase' : 'layers' }}" class="w-5 h-5 text-gray-400 group-hover:text-blue-600 transition-colors"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $activity['title'] }}</p>
                            <span class="text-[10px] uppercase font-black tracking-widest text-gray-400 shrink-0 ms-2">{{ $activity['time_ago'] }}</span>
                        </div>
                        <p class="text-xs text-gray-500">{{ $activity['date']->format('Y-m-d H:i') }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <i data-lucide="inbox" class="w-12 h-12 text-gray-200 dark:text-gray-800 mx-auto mb-4"></i>
                    <p class="text-gray-500">{{ __('No recent activity found.') }}</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- All Activity Modal --}}
        @if($showAllActivity)
        <div class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm"
             x-data x-on:click.self="$wire.toggleAllActivity()">
            <div class="bg-white dark:bg-gray-900 w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden border border-gray-100 dark:border-gray-800">
                <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                    <h3 class="text-xl font-black flex items-center gap-2">
                        <i data-lucide="history" class="w-6 h-6 text-blue-600"></i>
                        {{ __('Activity History') }}
                    </h3>
                    <button wire:click="toggleAllActivity" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>
                <div class="p-6 overflow-y-auto max-h-[70vh] space-y-3">
                    @foreach($allActivities as $activity)
                    <div class="flex items-center gap-4 p-4 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-xl transition-colors">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center shrink-0">
                            <i data-lucide="{{ $activity['type'] === 'Service' ? 'briefcase' : 'layers' }}" class="w-5 h-5 text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $activity['title'] }}</p>
                            <p class="text-[10px] text-gray-500">{{ $activity['date']->format('Y-m-d H:i') }} ({{ $activity['time_ago'] }})</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Server Health --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
                <h3 class="text-base font-black mb-6 flex items-center gap-2">
                    <i data-lucide="signal" class="w-5 h-5 text-green-500"></i>
                    {{ __('Server Health') }}
                </h3>
                <div class="space-y-5">
                    @foreach([
                        ['label' => __('Application Core'), 'pct' => 98, 'color' => 'from-green-500 to-emerald-400', 'badge' => __('Healthy'), 'badge_color' => 'text-green-600 bg-green-50'],
                        ['label' => __('Database Engine'),  'pct' => 92, 'color' => 'from-blue-500 to-indigo-400',  'badge' => __('Optimal'), 'badge_color' => 'text-blue-600 bg-blue-50'],
                        ['label' => __('Process Speed'),    'pct' => 88, 'color' => 'from-purple-500 to-pink-400',  'badge' => '85ms',        'badge_color' => 'text-purple-600 bg-purple-50'],
                    ] as $bar)
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-bold text-gray-600 dark:text-gray-400">{{ $bar['label'] }}</span>
                            <span class="text-xs font-bold px-2 py-0.5 rounded-full {{ $bar['badge_color'] }}">{{ $bar['badge'] }}</span>
                        </div>
                        <div class="w-full h-2 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r {{ $bar['color'] }}" style="width: {{ $bar['pct'] }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Security --}}
            <div class="bg-gradient-to-br from-gray-900 to-blue-900 p-6 rounded-2xl shadow-xl text-white relative overflow-hidden group">
                <i data-lucide="shield-check" class="absolute -right-4 -bottom-4 w-28 h-28 text-white/5 group-hover:scale-110 transition-transform"></i>
                <h4 class="text-lg font-black mb-3 relative z-10">{{ __('Security Advisor') }}</h4>
                @if($auditResults)
                <div class="space-y-3 mb-4 relative z-10">
                    @foreach($auditResults as $res)
                    <div class="flex items-center justify-between p-3 bg-white/5 rounded-xl border border-white/10">
                        <div>
                            <p class="text-xs font-bold">{{ $res['title'] }}</p>
                            <p class="text-[10px] text-blue-200/60">{{ $res['desc'] }}</p>
                        </div>
                        <div class="w-2 h-2 rounded-full {{ $res['status'] === 'success' ? 'bg-green-400' : 'bg-amber-400' }}"></div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-blue-100/80 text-sm leading-relaxed mb-4 relative z-10">
                    {{ __('Your system has been scanned for vulnerabilities. All protocols are active and firewall is shielding incoming connections.') }}
                </p>
                @endif
                <button wire:click="runAudit" wire:loading.attr="disabled"
                    class="w-full py-2.5 bg-white/10 hover:bg-white/20 border border-white/20 rounded-xl text-xs font-black uppercase tracking-widest transition-all relative z-10 flex items-center justify-center gap-2">
                    <span wire:loading.remove wire:target="runAudit">{{ __('Run Security Audit') }}</span>
                    <span wire:loading wire:target="runAudit" class="flex items-center gap-2">
                        <i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>{{ __('Scanning...') }}
                    </span>
                </button>
            </div>

            {{-- Top Pages --}}
            <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm">
                <h4 class="text-sm font-black mb-5 flex items-center gap-2">
                    <i data-lucide="bar-chart-2" class="w-4 h-4 text-blue-600"></i>
                    {{ __('Top Visited Pages') }}
                </h4>
                <div class="space-y-4">
                    @forelse($visitorStats['top_pages'] as $page)
                    <div>
                        <div class="flex items-center justify-between text-xs mb-1">
                            <span class="text-gray-600 dark:text-gray-400 truncate max-w-[150px]">{{ str_replace(url('/'), '', $page->url) ?: '/' }}</span>
                            <span class="font-bold text-gray-900 dark:text-white">{{ $page->count }}</span>
                        </div>
                        <div class="w-full h-1.5 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-600 rounded-full" style="width: {{ min(100, ($page->count / max(1, $visitorStats['total_today'])) * 100) }}%"></div>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-gray-400 text-center py-4">{{ __('No visits today yet.') }}</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
