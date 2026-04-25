<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\ServiceService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    /**
     * Display a listing of services
     */
    public function index()
    {
        $services = $this->serviceService->listServices(['active_only' => true]);
        return view('web.services.index', compact('services'));
    }

    /**
     * Display the specified service
     */
    public function show($slug)
    {
        $service = $this->serviceService->getServiceBySlug($slug);

        if (!$service || (!$service->is_active && !auth()->check())) {
            abort(404);
        }

        $relatedProjects = collect(); // For now, pass empty collection to avoid errors

        return view('web.services.show', compact('service', 'relatedProjects'));
    }
}
