<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * GET /api/programs - Protected Endpoint (Materi Slide 1 Step 03)
     * Hanya dapat diakses jika Authorization: Bearer <valid_token> dikirim.
     */
    public function index()
    {
        $programs = Program::select('id', 'name', 'description')->get();

        // Fallback jika tabel masih kosong sebelum di-seed
        if ($programs->isEmpty()) {
            $programs = collect([
                [
                    'id' => 1,
                    'name' => 'Program A',
                    'description' => 'AutoGloss Paint Protection Film (PPF) Training'
                ],
                [
                    'id' => 2,
                    'name' => 'Program B',
                    'description' => 'Ceramic Coating Specialist Masterclass'
                ],
            ]);
        }

        return response()->json([
            'data' => $programs
        ], 200);
    }

    /**
     * POST /api/programs - Tambah data program baru (Protected)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $program = Program::create($validated);

        return response()->json([
            'message' => 'Program berhasil ditambahkan',
            'data' => $program
        ], 201);
    }
}
