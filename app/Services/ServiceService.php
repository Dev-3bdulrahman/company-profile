<?php

namespace App\Services;

use App\Models\Service;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceService
{
    /**
     * List services with optional filtering
     */
    public function listServices(array $filters = []): Collection
    {
        $query = Service::orderBy('sort_order', 'asc');

        if (!empty($filters['active_only'])) {
            $query->active()->whereNotNull('slug');
        }

        if (!empty($filters['search'])) {
            $locale = app()->getLocale();
            $query->where(function($q) use ($filters, $locale) {
                $q->where('title->' . $locale, 'like', '%' . $filters['search'] . '%')
                  ->orWhere('slug', 'like', '%' . $filters['search'] . '%');
            });
        }

        return $query->get();
    }

    /**
     * Get a single service by ID
     */
    public function getServiceById(int $id): Service
    {
        return Service::findOrFail($id);
    }

    /**
     * Get a single service by slug
     */
    public function getServiceBySlug(string $slug): ?Service
    {
        return Service::where('slug', $slug)->first();
    }

    /**
     * Create or Update a service
     */
    public function saveService(array $data, ?int $id = null): Service
    {
        // Handle Slug
        if (empty($data['slug'])) {
            $title = is_array($data['title']) ? ($data['title']['en'] ?? reset($data['title'])) : $data['title'];
            $data['slug'] = Str::slug($title);
        }

        // Handle Hero Image
        if (isset($data['hero_image']) && $data['hero_image'] instanceof \Illuminate\Http\UploadedFile) {
            if ($id) {
                $oldService = Service::find($id);
                if ($oldService && $oldService->hero_image) {
                    Storage::disk('public')->delete($oldService->hero_image);
                }
            }
            $data['hero_image'] = $data['hero_image']->store('services/hero', 'public');
        }

        // Handle Gallery Uploads
        if (isset($data['gallery_uploads']) && is_array($data['gallery_uploads'])) {
            $gallery = $data['gallery'] ?? [];
            foreach ($data['gallery_uploads'] as $file) {
                if ($file instanceof \Illuminate\Http\UploadedFile) {
                    $gallery[] = $file->store('services/gallery', 'public');
                }
            }
            $data['gallery'] = $gallery;
        }

        if ($id) {
            $service = Service::findOrFail($id);
            $service->update($data);
        } else {
            $service = Service::create($data);
        }

        // Handle Project Relationships
        if (isset($data['project_ids'])) {
            $service->projects()->sync($data['project_ids']);
        }

        return $service;
    }

    /**
     * Delete a service
     */
    public function deleteService(int $id): bool
    {
        $service = Service::findOrFail($id);
        
        if ($service->hero_image) {
            Storage::disk('public')->delete($service->hero_image);
        }
        
        if (is_array($service->gallery)) {
            foreach ($service->gallery as $img) {
                Storage::disk('public')->delete($img);
            }
        }

        return $service->delete();
    }

    /**
     * Toggle active status
     */
    public function toggleStatus(int $id): bool
    {
        $service = Service::findOrFail($id);
        $service->is_active = !$service->is_active;
        return $service->save();
    }

    /**
     * Update sort order
     */
    public function updateOrders(array $orders): void
    {
        foreach ($orders as $order) {
            Service::where('id', $order['id'])->update(['sort_order' => $order['order']]);
        }
    }
}
