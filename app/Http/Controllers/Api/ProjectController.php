<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    /**
     * API Placeholder for listing projects
     */
    public function index(Request $request)
    {
        $filters = $request->only(['project_type_id', 'search', 'featured_only']);
        $filters['published_only'] = true;
        
        $projects = $this->projectService->listProjects($filters);
        
        return response()->json([
            'success' => true,
            'data' => $projects
        ]);
    }

    /**
     * API Placeholder for single project
     */
    public function show($slug)
    {
        $project = $this->projectService->getProjectBySlug($slug);
        
        if (!$project) {
            return response()->json(['success' => false, 'message' => 'Project not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $project
        ]);
    }
}
