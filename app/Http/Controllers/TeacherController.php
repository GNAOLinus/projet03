<?php

namespace App\Http\Controllers;

use App\Models\Memoire;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $memoire= Memoire::all();
        return view('teacher.dashboard',['memoires'=>$memoire]);
    }
}
