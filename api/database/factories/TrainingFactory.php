<?php

namespace Database\Factories;

use App\Models\Training;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrainingFactory extends Factory
{
    protected $model = Training::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->randomElement([
                'Treino de Peito',
                'Treino de Costas',
                'Treino de Pernas',
                'Treino de Braços',
                'Treino Funcional'
            ]),
            'description' => $this->faker->paragraph,
            'level' => $this->faker->randomElement(['beginner', 'intermediate', 'advanced']),
        ];
    }
}