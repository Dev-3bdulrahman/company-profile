<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\Internal\PortfolioManagementService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $portfolioService;

    public function __construct(PortfolioManagementService $portfolioService)
    {
        $this->portfolioService = $portfolioService;
    }

    /**
     * Display a listing of projects
     */
    public function index(Request $request)
    {
        $projects = $this->portfolioService->getActivePortfolioItems();
        return view('web.projects.index', compact('projects'));
    }

    /**
     * Display the specified project
     */
    public function show($slug)
    {
        $project = $this->portfolioService->getPortfolioItemBySlug($slug);

        if (!$project || (!$project->is_active && !auth()->check())) {
            abort(404);
        }

        return view('web.projects.show', compact('project'));
    }
}
