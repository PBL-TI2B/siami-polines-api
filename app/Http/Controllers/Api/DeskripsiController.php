<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Deskripsi;
use Illuminate\Http\Request;

class DeskripsiController extends Controller
{
    // Method untuk mengembalikan semua data deskripsi
    public function index()
    {
        // Ambil semua data deskripsi
        $deskripsi = Deskripsi::all();

        // Kembalikan response dalam format JSON
        return response()->json([
            'message' => 'Data Deskripsi berhasil diambil.',
            'data' => $deskripsi
        ]);
    }

    // Jika ingin menambahkan API GET untuk data berdasarkan kriteria_id
    public function showByKriteria($kriteria_id)
    {
        // Ambil data deskripsi berdasarkan kriteria_id
        $deskripsi = Deskripsi::where('kriteria_id', $kriteria_id)->get();

        if ($deskripsi->isEmpty()) {
            return response()->json([
                'message' => 'Deskripsi tidak ditemukan untuk kriteria tersebut.'
            ], 404);
        }

        return response()->json([
            'message' => 'Data Deskripsi berhasil diambil.',
            'data' => $deskripsi
        ]);
    }
    // Method untuk menambahkan data deskripsi
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'kriteria_id' => 'required|exists:kriteria,kriteria_id',
                'isi_deskripsi' => 'required|string',
            ]);

            // Membuat instance baru
            $deskripsi = new Deskripsi();
            $deskripsi->kriteria_id = $validated['kriteria_id'];
            $deskripsi->isi_deskripsi = $validated['isi_deskripsi'];
            $deskripsi->save();

            return response()->json([
                'message' => 'Deskripsi berhasil ditambahkan.',
                'data' => $deskripsi
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'kriteria_id' => 'required|exists:kriteria,kriteria_id', // Validasi kriteria_id yang ada
            'isi_deskripsi' => 'required|string', // Validasi isi_deskripsi yang sesuai
        ]);

        // Cari data deskripsi berdasarkan ID
        $deskripsi = Deskripsi::find($id);

        // Cek jika data deskripsi tidak ditemukan
        if (!$deskripsi) {
            return response()->json([
                'message' => 'Deskripsi tidak ditemukan.',
            ], 404);
        }

        // Update data deskripsi
        $deskripsi->kriteria_id = $validated['kriteria_id'];
        $deskripsi->isi_deskripsi = $validated['isi_deskripsi'];
        $deskripsi->save();

        // Kembalikan response sukses
        return response()->json([
            'message' => 'Deskripsi berhasil diperbarui.',
            'data' => $deskripsi,
        ], 200);
    }
    public function destroy($id)
    {
        // Cari data deskripsi berdasarkan ID
        $deskripsi = Deskripsi::find($id);

        // Cek jika data deskripsi tidak ditemukan
        if (!$deskripsi) {
            return response()->json([
                'message' => 'Deskripsi tidak ditemukan.',
            ], 404);
        }

        // Hapus data deskripsi
        $deskripsi->delete();

        // Kembalikan response sukses
        return response()->json([
            'message' => 'Deskripsi berhasil dihapus.',
        ], 200);
    }
}