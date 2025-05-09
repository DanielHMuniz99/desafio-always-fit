<?php

namespace App\Http\Controllers;

use App\Services\TrainingProgressService;
use Illuminate\Http\Request;

class ProgressLogsController extends Controller
{
    public function __construct(
        protected TrainingProgressService $progressService
    ) {}

    public function index(Request $request)
    {
        $progressData = $this->progressService
            ->calculateTrainingProgress($request->user()->id);

        return response()->json([
            'data' => $progressData,
            'meta' => $this->progressService->getAggregatedMetrics($progressData)
        ]);
    }
}