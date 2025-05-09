<?php

namespace Database\Seeders;

use App\Models\NutritionPlan;
use Illuminate\Database\Seeder;

class NutritionPlanSeeder extends Seeder
{
    public function run()
    {
        $plans = [
            [
                'title' => 'Plano B - Low Carb',
                'details' => 'Café: Ovos e abacate | Almoço: Salmão e brócolis | Janta: Frango e couve-flor'
            ],
            [
                'title' => 'Plano C - Vegetariano',
                'details' => 'Café: Tofu e quinoa | Almoço: Lentilha e arroz integral | Janta: Grão-de-bico e abóbora'
            ],
            [
                'title' => 'Plano D - Hipercalórico',
                'details' => 'Café: Aveia e whey | Almoço: Arroz, feijão, carne e batata-doce | Janta: Massa integral e atum'
            ],
            [
                'title' => 'Plano E - Cetogênico',
                'details' => 'Café: Ovos e bacon | Almoço: Carne e vegetais verdes | Janta: Peixe e abacate'
            ],
            [
                'title' => 'Plano F - Mediterrâneo',
                'details' => 'Café: Iogurte e nozes | Almoço: Peixe grelhado e salada | Janta: Frango e legumes assados'
            ]
        ];

        foreach ($plans as $plan) {
            NutritionPlan::create($plan);
        }

        NutritionPlan::create([
            'title' => 'Plano A - Básico',
            'details' => 'Inclui frango, arroz e vegetais'
        ]);
    }
}