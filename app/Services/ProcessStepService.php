<?php

namespace App\Services;

use App\Models\ProcessStep;
use Illuminate\Support\Collection;

class ProcessStepService
{
    /**
     * List process steps with optional filtering
     */
    public function listProcessSteps(array $filters = []): Collection
    {
        $query = ProcessStep::orderBy('sort_order', 'asc');

        if (!empty($filters['active_only'])) {
            $query->where('is_active', true);
        }

        return $query->get();
    }

    /**
     * Save or update a process step
     */
    public function saveProcessStep(array $data, ?int $id = null): ProcessStep
    {
        if ($id) {
            $step = ProcessStep::findOrFail($id);
            $step->update($data);
        } else {
            $step = ProcessStep::create($data);
        }

        return $step;
    }

    /**
     * Delete a process step
     */
    public function deleteProcessStep(int $id): bool
    {
        return ProcessStep::findOrFail($id)->delete();
    }

    /**
     * Toggle active status
     */
    public function toggleStatus(int $id): bool
    {
        $step = ProcessStep::findOrFail($id);
        $step->is_active = !$step->is_active;
        return $step->save();
    }
}
