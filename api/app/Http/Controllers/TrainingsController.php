<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;

class TrainingsController extends Controller
{
    public function index(Request $request)
    {
        $query = Training::query();
        return response()->json($query->get());
    }
}
