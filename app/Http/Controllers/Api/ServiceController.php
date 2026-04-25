<?php

namespace App\Http\Controllers\Api;

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
     * API Placeholder for listing services
     */
    public function index()
    {
        $services = $this->serviceService->listServices(['active_only' => true]);
        return response()->json([
            'success' => true,
            'data' => $services
        ]);
    }

    /**
     * API Placeholder for single service
     */
    public function show($slug)
    {
        $service = $this->serviceService->getService($slug);
        
        if (!$service) {
            return response()->json(['success' => false, 'message' => 'Service not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $service
        ]);
    }
}
