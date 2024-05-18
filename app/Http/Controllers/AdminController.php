<?php

namespace App\Http\Controllers;

use App\Models\promotion;

class AdminController extends Controller
{
    public function index()
{
    // Récupérer toutes les promotions
    $promotions = Promotion::orderBy('created_at', 'desc')->get();
    
    // Passer les promotions à la vue
    return view('admin.dashboard', compact('promotions'));
}
}