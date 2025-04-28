<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tilik;
use Illuminate\Http\Request;

class TilikController extends Controller
{
    // GET: List semua data
    public function index()
    {
        $tilik = Tilik::all();
        return response()->json([
            'success' => true,
            'message' => 'List Data Tilik',
            'data' => $tilik
        ], 200);
    }

    // POST: Tambah data baru
    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'indikator' => 'required|string',
            'sumber_data' => 'required|string',
            'metode_perhitungan' => 'required|string',
            'target' => 'required|string',
        ]);

        $tilik = Tilik::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data Tilik Berhasil Disimpan',
            'data' => $tilik
        ], 201);
    }

    // GET: Ambil 1 data berdasarkan ID
    public function show($id)
    {
        $tilik = Tilik::find($id);

        if ($tilik) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Data Tilik',
                'data' => $tilik
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Tilik Tidak Ditemukan',
            ], 404);
        }
    }

    // PUT/PATCH: Update data berdasarkan ID
    public function update(Request $request, $id)
    {
        $tilik = Tilik::find($id);

        if (!$tilik) {
            return response()->json([
                'success' => false,
                'message' => 'Data Tilik Tidak Ditemukan',
            ], 404);
        }

        $tilik->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data Tilik Berhasil Diupdate',
            'data' => $tilik
        ], 200);
    }

    // DELETE: Hapus data berdasarkan ID
    public function destroy($id)
    {
        $tilik = Tilik::find($id);

        if (!$tilik) {
            return response()->json([
                'success' => false,
                'message' => 'Data Tilik Tidak Ditemukan',
            ], 404);
        }

        $tilik->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Tilik Berhasil Dihapus',
        ], 200);
    }
}
