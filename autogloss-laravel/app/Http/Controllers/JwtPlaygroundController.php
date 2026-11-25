<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;

class JwtPlaygroundController extends Controller
{
    /**
     * Halaman Interaktif Pengujian JWT Authentication (Week 11)
     * Menampilkan visualisasi interaktif Slide 1 (Task 03) & Checklist Slide 2
     */
    public function index()
    {
        $demoUser = User::where('email', 'user@example.com')->first();
        $totalPrograms = Program::count();

        return view('jwt-testing', compact('demoUser', 'totalPrograms'));
    }
}
