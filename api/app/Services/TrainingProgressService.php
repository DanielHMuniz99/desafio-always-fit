<?php

namespace App\Services;

use App\Models\Training;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TrainingProgressService
{
    public function calculateTrainingProgress(int $userId): Collection
    {
        return Training::with(['progressLogs' => function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->orderBy('completed_at', 'desc');
            }])
            ->where('user_id', $userId)
            ->get()
            ->map(function (Training $training) {
                $logs = $training->progressLogs;
                
                return [
                    'training_id' => $training->id,
                    'title' => $training->title,
                    'level' => $training->level,
                    'description' => $training->description,
                    'completed_days' => $logs->count(),
                    'progress_percentage' => $this->calculateProgressPercentage($logs),
                    'last_completed' => optional($logs->first())->completed_at,
                    'completed_today' => $this->checkCompletedToday($logs),
                    'logs' => $logs->take(5)->map(function ($log) {
                        return $log->completed_at;
                    }),
                ];
            });
    }

    protected function calculateProgressPercentage(Collection $logs): float
    {
        $completedDays = $logs->count();
        $targetDays = 30;
        
        return min(100, round(($completedDays / $targetDays) * 100, 2));
    }

    protected function checkCompletedToday(Collection $logs): bool
    {
        return $logs->contains(function ($log) {
            return $log->completed_at == Carbon::now()->toDateString();
        });
    }

    public function getAggregatedMetrics(Collection $progressData): array
    {
        return [
            'total_trainings' => $progressData->count(),
            'total_completed_days' => $progressData->sum('completed_days'),
            'average_progress' => round($progressData->avg('progress_percentage'), 2),
            'recent_completions' => $progressData->sum(function ($training) {
                return $training['logs']->count();
            }),
        ];
    }
}