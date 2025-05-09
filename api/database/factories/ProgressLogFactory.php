<?php

namespace Database\Factories;

use App\Models\ProgressLog;
use App\Models\Training;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProgressLogFactory extends Factory
{
    protected $model = ProgressLog::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'training_id' => Training::factory(),
            'completed_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}