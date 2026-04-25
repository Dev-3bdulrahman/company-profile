<?php

namespace App\Services;

use App\Models\Testimonial;
use Illuminate\Support\Collection;

class TestimonialService
{
    /**
     * List testimonials with optional filtering
     */
    public function listTestimonials(array $filters = []): Collection
    {
        $query = Testimonial::orderBy('sort_order', 'asc');

        if (!empty($filters['active_only'])) {
            $query->where('is_active', true);
        }

        return $query->get();
    }

    /**
     * Save or update a testimonial
     */
    public function saveTestimonial(array $data, ?int $id = null): Testimonial
    {
        if ($id) {
            $testimonial = Testimonial::findOrFail($id);
            $testimonial->update($data);
        } else {
            $testimonial = Testimonial::create($data);
        }

        return $testimonial;
    }

    /**
     * Delete a testimonial
     */
    public function deleteTestimonial(int $id): bool
    {
        return Testimonial::findOrFail($id)->delete();
    }

    /**
     * Toggle active status
     */
    public function toggleStatus(int $id): bool
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->is_active = !$testimonial->is_active;
        return $testimonial->save();
    }
}
