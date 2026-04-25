<?php

namespace App\Http\Controllers\Web\Admin\VisitorLogs;

use App\Models\VisitorLog;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 15;

    #[Layout('layouts.admin')]
    public function render()
    {
        $logs = VisitorLog::query()
            ->when($this->search, function($q) {
                $q->where('ip_address', 'like', '%' . $this->search . '%')
                  ->orWhere('url', 'like', '%' . $this->search . '%')
                  ->orWhere('country', 'like', '%' . $this->search . '%')
                  ->orWhere('city', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.visitor-logs.index', compact('logs'))
            ->title(__('Visitor Logs'));
    }

    public function clearLogs()
    {
        VisitorLog::truncate();
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => __('All logs cleared successfully.')
        ]);
    }
}
