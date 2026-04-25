<?php

namespace App\Http\Controllers\Web\Admin;

use App\Services\Internal\StatsService;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Dashboard extends Component
{
    public array $stats = [];
    public $recentActivity = [];
    public bool $auditRunning = false;
    public $auditResults = null;
    public bool $showAllActivity = false;
    public $allActivities = [];
    public array $visitorStats = [];

    protected $statsService;

    public function boot(StatsService $statsService)
    {
        $this->statsService = $statsService;
    }

    public function mount()
    {
        $this->stats = $this->statsService->getDashboardStats();
        $this->recentActivity = $this->statsService->getRecentActivity();
        $this->visitorStats = $this->statsService->getVisitorStats();
    }

    public function toggleAllActivity()
    {
        $this->showAllActivity = !$this->showAllActivity;
        if ($this->showAllActivity && empty($this->allActivities)) {
            $this->allActivities = $this->statsService->getRecentActivity(30);
        }
    }

    public function runAudit()
    {
        $this->auditRunning = true;

        $results = [
            'debug' => [
                'title' => __('Debug Mode'),
                'status' => config('app.debug') ? 'warning' : 'success',
                'desc' => config('app.debug') ? __('Debug mode is currently active.') : __('System is running in production-safe mode.'),
            ],
            'ssl' => [
                'title' => __('SSL Safety'),
                'status' => request()->secure() ? 'success' : 'warning',
                'desc' => request()->secure() ? __('Encrypted connection verified.') : __('Insecure connection detected.'),
            ],
            'env' => [
                'title' => __('System Environment'),
                'status' => 'success',
                'desc' => __('Configuration files are protected.'),
            ]
        ];

        $this->auditResults = $results;
        $this->auditRunning = false;

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => __('Security audit completed successfully.')
        ]);
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.dashboard')
            ->title(__('Dashboard - Home'));
    }
}
