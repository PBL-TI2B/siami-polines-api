<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    // Ambil semua data kriteria
    public function index()
    {
        $kriteria = Kriteria::all();
        return response()->json($kriteria);
    }

    // Ambil satu kriteria berdasarkan ID
    public function show($id)
    {
        $kriteria = Kriteria::find($id);

        if ($kriteria) {
            return response()->json($kriteria);
        } else {
            return response()->json([
                'message' => 'Kriteria tidak ditemukan.'
            ], 404);
        }
    }
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'nomor' => 'required|integer',  // Menambahkan validasi untuk kolom nomor
        ]);

        // Simpan data ke database
        $kriteria = new Kriteria();
        $kriteria->nama_kriteria = $request->nama_kriteria;
        $kriteria->nomor = $request->nomor;  // Menambahkan kolom nomor
        $kriteria->save();

        return response()->json([
            'message' => 'Kriteria berhasil ditambahkan.',
            'data' => $kriteria
        ], 201);
    }
    public function update(Request $request, $id)
    {
        // Cari data kriteria berdasarkan ID
        $kriteria = Kriteria::find($id);

        if (!$kriteria) {
            return response()->json([
                'message' => 'Kriteria tidak ditemukan.'
            ], 404);
        }

        // Validasi input
        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'nomor' => 'required|integer',  // Menambahkan validasi untuk kolom nomor
        ]);

        // Update data
        $kriteria->nama_kriteria = $request->nama_kriteria;
        $kriteria->nomor = $request->nomor;  // Menambahkan update untuk kolom nomor
        $kriteria->save();

        return response()->json([
            'message' => 'Kriteria berhasil diupdate.',
            'data' => $kriteria
        ]);
    }
    public function destroy($id)
    {
        // Cari data kriteria berdasarkan ID
        $kriteria = Kriteria::find($id);

        if (!$kriteria) {
            return response()->json([
                'message' => 'Kriteria tidak ditemukan.'
            ], 404);
        }

        // Hapus data kriteria
        $kriteria->delete();

        return response()->json([
            'message' => 'Kriteria berhasil dihapus.'
        ]);
    }
}
