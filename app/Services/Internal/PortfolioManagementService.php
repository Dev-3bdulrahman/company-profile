<?php

namespace App\Services\Internal;

use App\Models\PortfolioItem;

class PortfolioManagementService extends BaseInternalService
{
    public function getAllPortfolioItems()
    {
        return PortfolioItem::orderBy('sort_order', 'asc')->latest()->get();
    }

    public function getActivePortfolioItems()
    {
        return PortfolioItem::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->latest()
            ->get();
    }

    public function getPortfolioItemBySlug(string $slug): ?PortfolioItem
    {
        return PortfolioItem::where('slug', $slug)->first();
    }

    public function savePortfolioItem(array $data, ?int $id = null): bool
    {
        if ($id) {
            $item = PortfolioItem::findOrFail($id);
            $item->update($data);
        }
        else {
            PortfolioItem::create($data);
        }

        return true;
    }

    public function updateOrCreateByBehanceUrl(array $data, string $url): PortfolioItem
    {
        return PortfolioItem::updateOrCreate(
        ['behance_url' => $url],
            $data
        );
    }

    public function deletePortfolioItem(int $id): bool
    {
        return PortfolioItem::destroy($id) > 0;
    }

    public function rebalanceOrders()
    {
        $items = PortfolioItem::orderBy('sort_order', 'asc')->orderBy('updated_at', 'desc')->get();
        foreach ($items as $index => $item) {
            $item->update(['sort_order' => $index + 1]);
        }
    }

    /**
     * Sync projects from a Behance profile.
     */
    public function syncFromBehanceProfile(string $profileUrl, \App\Services\External\BehanceService $behanceService): int
    {
        $projectUrls = $behanceService->fetchProfileProjects($profileUrl);
        if (empty($projectUrls)) {
            return 0;
        }

        $count = 0;
        $existingUrls = PortfolioItem::whereNotNull('behance_url')->pluck('behance_url')->toArray();

        foreach ($projectUrls as $pData) {
            $url = is_array($pData) ? $pData['url'] : $pData;
            $publishedOn = is_array($pData) ? ($pData['published_on'] ?? null) : null;

            if (in_array($url, $existingUrls)) {
                continue;
            }

            $metadata = $behanceService->fetchProjectMetadata($url);
            if (!empty($metadata)) {
                $data = [
                    'title' => ['ar' => $metadata['title'] ?? '', 'en' => $metadata['title'] ?? ''],
                    'description' => ['ar' => $metadata['description'] ?? '', 'en' => $metadata['description'] ?? ''],
                    'year' => $metadata['year'] ?? ($publishedOn ? date('Y', $publishedOn) : date('Y')),
                    'color' => 'orange',
                    'behance_url' => $url,
                    'behance_id' => $metadata['behance_id'] ?? null,
                    'image' => $metadata['image'] ?? null,
                    'gallery' => $metadata['gallery'] ?? [],
                    'is_active' => true,
                    'sort_order' => $count,
                ];
                $this->savePortfolioItem($data);
                $count++;
            }
        }

        return $count;
    }

    /**
     * Toggle like for a portfolio item based on IP address.
     */
    public function toggleLike(int $itemId, string $ip): array
    {
        $item = PortfolioItem::findOrFail($itemId);
        
        $exists = \Illuminate\Support\Facades\DB::table('portfolio_likes')
            ->where('portfolio_item_id', $item->id)
            ->where('ip_address', $ip)
            ->exists();

        if ($exists) {
            \Illuminate\Support\Facades\DB::table('portfolio_likes')
                ->where('portfolio_item_id', $item->id)
                ->where('ip_address', $ip)
                ->delete();
            $liked = false;
        } else {
            \Illuminate\Support\Facades\DB::table('portfolio_likes')->insert([
                'portfolio_item_id' => $item->id,
                'ip_address' => $ip,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $liked = true;
        }

        $count = $this->getLikeCount($item->id);

        return ['liked' => $liked, 'count' => $count];
    }

    public function getLikeCount(int $itemId): int
    {
        return \Illuminate\Support\Facades\DB::table('portfolio_likes')->where('portfolio_item_id', $itemId)->count();
    }
}