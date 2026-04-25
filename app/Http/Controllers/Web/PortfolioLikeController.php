<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;
use Illuminate\Http\Request;
use App\Services\Internal\PortfolioManagementService;

class PortfolioLikeController extends Controller
{
    public function __invoke(Request $request, PortfolioItem $item, PortfolioManagementService $service)
    {
        $result = $service->toggleLike($item->id, $request->ip());

        return $this->success($result, 'Like status updated');
    }
}
