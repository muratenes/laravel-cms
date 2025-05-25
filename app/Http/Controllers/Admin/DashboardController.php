<?php

namespace App\Http\Controllers\Admin;

use App\Services\DashboardService;
class DashboardController extends AdminController
{
    public function __construct(private readonly DashboardService $dashboardService)
    {
    }

    public function init(): \Illuminate\Http\JsonResponse
    {
        return response()->json(
            $this->dashboardService->init()
        );
    }
}
