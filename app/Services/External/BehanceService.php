<?php

namespace App\Services\External;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BehanceService extends BaseExternalService
{
    /**
     * Fetch project metadata from a Behance URL.
     * Extracts title, description, and image from OpenGraph tags.
     */
    public function fetchProjectMetadata(string $url): array
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
            ])->get($url);

            if (!$response->successful()) {
                return [];
            }

            $html = $response->body();
            $metadata = [];

            // Extract OpenGraph tags
            preg_match('/<meta property="og:title" content="([^"]+)"/i', $html, $matches);
            $metadata['title'] = $matches[1] ?? '';

            preg_match('/<meta property="og:description" content="([^"]+)"/i', $html, $matches);
            $metadata['description'] = $matches[1] ?? '';

            preg_match('/<meta property="og:image" content="([^"]+)"/i', $html, $matches);
            $remoteImageUrl = $matches[1] ?? '';

            // Extract Behance Project ID from URL if possible
            if (preg_match('/gallery\/(\d+)/i', $url, $matches)) {
                $metadata['behance_id'] = $matches[1];

                // Try to get more metadata from NAPI
                $napiUrl = "https://www.behance.net/napi/v2/projects/{$metadata['behance_id']}";
                $napiResponse = Http::withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'X-Requested-With' => 'XMLHttpRequest'
                ])->get($napiUrl);

                if ($napiResponse->successful()) {
                    $projectData = $napiResponse->json();
                    if (!empty($projectData['project'])) {
                        $p = $projectData['project'];
                        $metadata['title'] = $p['name'] ?? $metadata['title'];
                        $metadata['description'] = $p['description'] ?? $metadata['description'];
                        if (!empty($p['published_on'])) {
                            $metadata['year'] = date('Y', $p['published_on']);
                        }
                    }
                }
            }

            // Handle Cover Image Download
            if ($remoteImageUrl) {
                $metadata['image'] = $this->downloadRemoteImage($remoteImageUrl);
            }

            // Extract Gallery Images
            preg_match_all('/https:\/\/mir-s3-cdn-cf\.behance\.net\/project_modules\/([^\/]+)\/([^\/\s\"]+\.(?:jpg|png|gif|jpeg|webp))/i', $html, $matches);
            if (!empty($matches[0])) {
                $uniqueImages = [];
                for ($i = 0; $i < count($matches[0]); $i++) {
                    $quality = $matches[1][$i];
                    $filename = $matches[2][$i];

                    $qualityRank = match (true) {
                            str_contains($quality, 'max_3840') => 4,
                            str_contains($quality, '2800') => 3,
                            str_contains($quality, '1400') => 2,
                            default => 1,
                        };

                    if (!isset($uniqueImages[$filename]) || $uniqueImages[$filename]['rank'] < $qualityRank) {
                        $uniqueImages[$filename] = [
                            'url' => $matches[0][$i],
                            'rank' => $qualityRank
                        ];
                    }
                }

                $galleryUrls = array_column($uniqueImages, 'url');
                $metadata['gallery'] = [];
                foreach (array_slice($galleryUrls, 0, 15) as $gUrl) {
                    $localPath = $this->downloadRemoteImage($gUrl, 'gallery');
                    if ($localPath) {
                        $metadata['gallery'][] = $localPath;
                    }
                }
            }

            return array_filter($metadata);
        }
        catch (\Exception $e) {
            Log::error("Failed to fetch Behance metadata: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Attempt to fetch all project URLs from a Behance profile.
     * This is a basic implementation that looks for gallery links.
     */
    public function fetchProfileProjects(string $profileUrl): array
    {
        try {
            // Extract username from profile URL
            $path = parse_url($profileUrl, PHP_URL_PATH);
            $segments = explode('/', trim($path, '/'));
            $username = $segments[0] ?? null;

            if ($username) {
                $allProjectUrls = [];
                $page = 1;
                $hasMore = true;

                while ($hasMore && $page <= 20) { // Safety limit of 20 pages (approx 960 projects)
                    $napiUrl = "https://www.behance.net/napi/v2/users/{$username}/projects?page={$page}";
                    $response = Http::withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                        'X-Requested-With' => 'XMLHttpRequest'
                    ])->get($napiUrl);

                    if ($response->successful()) {
                        $data = $response->json();
                        if (!empty($data['projects'])) {
                            $allProjectUrls = array_merge($allProjectUrls, $data['projects']);

                            if (count($data['projects']) < 40) {
                                $hasMore = false;
                            }
                            else {
                                $page++;
                            }
                        }
                        else {
                            $hasMore = false;
                        }
                    }
                    else {
                        $hasMore = false;
                    }
                }

                if (!empty($allProjectUrls)) {
                    return $allProjectUrls;
                }
            }

            // Fallback to HTML scraping (single page)
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
            ])->get($profileUrl);

            if (!$response->successful()) {
                return [];
            }

            $html = $response->body();
            $projectUrls = [];

            // Look for gallery links
            preg_match_all('/(?:"|\')((?:https:\/\/www\.behance\.net)?\/gallery\/\d+\/[a-zA-Z0-9-]+)(?:"|\')/i', $html, $matches);

            if (!empty($matches[1])) {
                foreach ($matches[1] as $match) {
                    $url = $match;
                    if (!Str::startsWith($url, 'http')) {
                        $url = 'https://www.behance.net' . (Str::startsWith($url, '/') ? '' : '/') . $url;
                    }
                    $projectUrls[] = $url;
                }
            }

            return array_values(array_unique($projectUrls));
        }
        catch (\Exception $e) {
            Log::error("Failed to fetch Behance profile projects: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Download a remote image and save it to public storage.
     */
    protected function downloadRemoteImage(string $url, string $subDir = 'portfolio'): ?string
    {
        try {
            $response = Http::get($url);
            if (!$response->successful()) {
                return null;
            }

            $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
            // Clean up extension if it has query params
            $extension = explode('?', $extension)[0];

            $filename = $subDir . '/' . Str::random(20) . '.' . $extension;

            Storage::disk('public')->put($filename, $response->body());

            return $filename;
        }
        catch (\Exception $e) {
            Log::error("Failed to download image from $url: " . $e->getMessage());
            return null;
        }
    }
}