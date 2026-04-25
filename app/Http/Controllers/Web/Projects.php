<?php

namespace App\Http\Controllers\Web;

use App\Services\Internal\PortfolioManagementService;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Projects extends Component
{
    public $portfolio;

    #[Layout('layouts.guest')]
    public function mount(PortfolioManagementService $pos)
    {
        $this->portfolio = $pos->getActivePortfolioItems();
    }

    public function render()
    {
        return view('livewire.projects');
    }
}
