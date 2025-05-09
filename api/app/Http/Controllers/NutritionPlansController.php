<?php

namespace App\Http\Controllers;

use App\Models\NutritionPlan;
use Illuminate\Http\Request;

class NutritionPlansController extends Controller
{
    public function index()
    {
        return NutritionPlan::all();
    }
}
