<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SasaranStrategis;

class SasaranStrategisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $SasaranStrategis = SasaranStrategis::all();
        return response()->json([
            'success' => true,
            'message' => 'List Data Sasaran Strategis',
            'data' => $SasaranStrategis
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // Validasi input
        $request->validate([
            'nama_sasaran' => 'required|string|max:500',
        ]);

        // Simpan data ke database
        $SasaranStrategis = new SasaranStrategis();
        $SasaranStrategis->nama_sasaran = $request->nama_sasaran;
        $SasaranStrategis->save();

        return response()->json([
            'message' => 'Sasaran Strategis berhasil ditambahkan.',
            'data' => [
                'nama_sasaran' => $SasaranStrategis->nama_sasaran
            ]
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $SasaranStrategis = SasaranStrategis::find($id);

        if ($SasaranStrategis) {
            return response()->json($SasaranStrategis);
        } else {
            return response()->json([
                'message' => 'Sasaran Strategis tidak ditemukan.'
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Cari data kriteria berdasarkan ID
        $SasaranStrategis = SasaranStrategis::find($id);

        if (!$SasaranStrategis) {
            return response()->json([
                'message' => 'Sasaran strategis tidak ditemukan.'
            ], 404);
        }

        // Validasi input
        $request->validate([
            'nama_sasaran' => 'required|string|max:255',
        ]);

        // Update data
        $SasaranStrategis->nama_sasaran = $request->nama_sasaran;
        $SasaranStrategis->save();

        return response()->json([
            'message' => 'Sasaran Strategis berhasil diupdate.',
            'data' => [
                $SasaranStrategis->nama_sasaran
            ]
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Cari data kriteria berdasarkan ID
        $SasaranStrategis = SasaranStrategis::find($id);

        if (!$SasaranStrategis) {
            return response()->json([
                'message' => 'Sasaran Strategis tidak ditemukan.'
            ], 404);
        }

        // Hapus data kriteria
        $SasaranStrategis->delete();

        return response()->json([
            'message' => 'Sasaran strategis berhasil dihapus.'
        ]);
    }
}
