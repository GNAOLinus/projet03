<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RedirectionController extends Controller
{
    public function redirection(){
        $userRole = Auth::user()->id_role; // Assuming role is stored in session
  
        switch ($userRole) {
            case '1':
                return redirect()->route('admin.dashboard');
            case '2':
                return redirect()->route('student.dashboard');
            case '3':
                return redirect()->route('teacher.dashboard', ['id_edit' => 'null']);
            case '4':
                return redirect()->route('admin.dashboard');
            default:
                return view('welcome');
        }
    }
}
