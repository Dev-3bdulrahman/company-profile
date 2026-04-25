<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Gates handled in controller/livewire
    }

    public function rules(): array
    {
        return [
            'title' => 'required|array',
            'title.*' => 'required|string|max:255',
            'slug' => 'required|string|unique:services,slug,' . ($this->service ? $this->service->id : 'NULL'),
            'short_description' => 'nullable|array',
            'description' => 'required|array',
            'hero_image' => 'nullable|string',
            'gallery' => 'nullable|array',
            'features' => 'nullable|array',
            'cta_text' => 'nullable|array',
            'cta_button_text' => 'nullable|array',
            'cta_url' => 'nullable|url',
            'faqs' => 'nullable|array',
            'seo_title' => 'nullable|array',
            'seo_description' => 'nullable|array',
            'seo_keywords' => 'nullable|array',
            'status' => 'required|in:published,draft',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
            'files' => 'nullable|array',
            'color' => 'nullable|string',
            'icon' => 'nullable|string',
        ];
    }
}
