<?php

namespace App\Http\Controllers\Api;

use App\Models\Unsur;

class UnsurController extends Controller
{
    public function index()
    {
        $unsurs = Unsur::all();

        return response()->json([
            'message' => 'Data unsur berhasil diambil.',
            'data' => $unsurs
        ], 200);
    }

    public function show($id)
    {
        $unsur = Unsur::with('deskripsi')->find($id);

        if (!$unsur) {
            return response()->json([
                'message' => 'Unsur tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'message' => 'Data unsur berhasil ditemukan.',
            'data' => $unsur
        ], 200);
    }
}
