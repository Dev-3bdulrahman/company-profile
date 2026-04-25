<?php

namespace App\Services\Internal;

use App\Models\Service;
use App\Models\PortfolioItem;
use App\Models\VisitorLog;
use App\Models\SiteSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatsService extends BaseInternalService
{
    public function getDashboardStats(): array
    {
        return [
            'services' => [
                'count' => Service::count(),
                'trend' => $this->getTrend(Service::class),
            ],
            'portfolio' => [
                'count' => PortfolioItem::count(),
                'trend' => $this->getTrend(PortfolioItem::class),
            ],
            'visitors_today' => VisitorLog::today()->count(),
            'unique_today'   => VisitorLog::uniqueToday()->count(),
        ];
    }

    public function getRecentActivity(int $limit = 10): array
    {
        $activities = collect();

        $models = [
            'Service'   => Service::class,
            'Portfolio' => PortfolioItem::class,
        ];

        foreach ($models as $type => $class) {
            $items = $class::latest()->take($limit)->get()->map(function ($item) use ($type) {
                return [
                    'type'     => $type,
                    'title'    => $this->getActivityTitle($item, $type),
                    'date'     => $item->created_at,
                    'time_ago' => $item->created_at->diffForHumans(),
                ];
            });
            $activities = $activities->concat($items);
        }

        return $activities->sortByDesc('date')->take($limit)->values()->all();
    }

    public function getVisitorStats(): array
    {
        return [
            'total_today'  => VisitorLog::today()->count(),
            'unique_today' => VisitorLog::uniqueToday()->count(),
            'top_pages'    => VisitorLog::today()
                ->select('url', DB::raw('count(*) as count'))
                ->groupBy('url')
                ->orderByDesc('count')
                ->take(5)
                ->get(),
            'devices'      => VisitorLog::today()
                ->select('device_type', DB::raw('count(*) as count'))
                ->groupBy('device_type')
                ->get(),
        ];
    }

    private function getTrend($model): int
    {
        $current  = $model::whereMonth('created_at', Carbon::now()->month)->count();
        $last     = $model::whereMonth('created_at', Carbon::now()->subMonth()->month)->count();

        if ($last == 0) return $current > 0 ? 100 : 0;

        return round((($current - $last) / $last) * 100);
    }

    private function getActivityTitle($item, $type): string
    {
        $title = method_exists($item, 'getTranslation')
            ? ($item->getTranslation('title') ?: $item->id)
            : ($item->title ?? $item->id);

        return match ($type) {
            'Service'   => __('New Service') . ': ' . $title,
            'Portfolio' => __('New Portfolio Item') . ': ' . $title,
            default     => __('Update in') . ' ' . $type,
        };
    }
}
