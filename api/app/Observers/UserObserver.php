<?php

namespace App\Observers;

use App\Models\ProgressLog;
use App\Models\Training;
use App\Models\User;
use Carbon\Carbon;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $trainings = Training::factory()
            ->count(rand(3, 5))
            ->create([
                'user_id' => $user->id
            ]);

        $trainings->each(function ($training) use ($user) {
            $daysToCreate = rand(5, 15);
            
            for ($i = 0; $i < $daysToCreate; $i++) {
                $completedAt = Carbon::today()
                    ->subDays(rand(0, 30))
                    ->addDays($i);
                
                ProgressLog::factory()->create([
                    'user_id' => $user->id,
                    'training_id' => $training->id,
                    'completed_at' => $completedAt
                ]);
            }

            if (rand(0, 1)) {
                ProgressLog::factory()->create([
                    'user_id' => $user->id,
                    'training_id' => $training->id,
                    'completed_at' => Carbon::today()
                ]);
            }
        });
    }

    public function updated(User $user): void {}
    public function deleted(User $user): void {}
    public function restored(User $user): void {}
    public function forceDeleted(User $user): void {}
}