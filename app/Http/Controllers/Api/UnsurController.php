<?php

namespace App\Http\Controllers\Api;

use App\Models\Unsur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    public function store(Request $request)
    {
        $request->validate([
            'deskripsi_id' => 'required|exists:deskripsi,deskripsi_id',
            'isi_unsur' => 'required|string',
        ]);

        $unsur = Unsur::create([
            'deskripsi_id' => $request->deskripsi_id,
            'isi_unsur' => $request->isi_unsur,
        ]);

        return response()->json([
            'message' => 'Data unsur berhasil disimpan.',
            'data' => $unsur
        ], 201);
    }
    public function update(Request $request, $id)
    {
        $unsur = Unsur::find($id);

        if (!$unsur) {
            return response()->json([
                'message' => 'Unsur tidak ditemukan.'
            ], 404);
        }

        $request->validate([
            'deskripsi_id' => 'required|exists:deskripsi,deskripsi_id',
            'isi_unsur' => 'required|string',
        ]);

        $unsur->update([
            'deskripsi_id' => $request->deskripsi_id,
            'isi_unsur' => $request->isi_unsur,
        ]);

        return response()->json([
            'message' => 'Data unsur berhasil diperbarui.',
            'data' => $unsur
        ], 200);
    }
    public function destroy($id)
    {
        $unsur = Unsur::find($id);

        if (!$unsur) {
            return response()->json([
                'message' => 'Unsur tidak ditemukan.'
            ], 404);
        }

        $unsur->delete();

        return response()->json([
            'message' => 'Data unsur berhasil dihapus.'
        ], 200);
    }
}