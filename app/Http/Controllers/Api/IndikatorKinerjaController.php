<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\IndikatorKinerja;

class IndikatorKinerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $IndikatorKinerja = IndikatorKinerja::all();
        return response()->json([
            'success' => true,
            'message' => 'List Data Indikator Kinerja',
            'data' => $IndikatorKinerja
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
            'sasaran_strategis_id' => 'required|exists:sasaran_strategis,sasaran_strategis_id',
            'isi_indikator_kinerja' => 'required|string',
        ]);

        // Simpan data ke database
        $IndikatorKinerja = new IndikatorKinerja();
        $IndikatorKinerja->sasaran_strategis_id = $request['sasaran_strategis_id'];
        $IndikatorKinerja->isi_indikator_kinerja = $request['isi_indikator_kinerja'];
        $IndikatorKinerja->save();

        // Load relasi untuk menghindari null atau lazy load error
        $IndikatorKinerja->load('sasaranStrategis');

        return response()->json([
            'message' => 'Indikator Kinerja berhasil ditambahkan.',
            'data' => [
                'sasaran_strategis' => $IndikatorKinerja->sasaranStrategis->nama_sasaran ?? null,
                'isi_indikator_kinerja' => $IndikatorKinerja->isi_indikator_kinerja
            ]
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $IndikatorKinerja = IndikatorKinerja::find($id);

        if ($IndikatorKinerja) {
            return response()->json($IndikatorKinerja);
        } else {
            return response()->json([
                'message' => 'Indikator Kinerja tidak ditemukan.'
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
    public function update(Request $request, $id)
    {
        // Cari data kriteria berdasarkan ID
        $IndikatorKinerja = IndikatorKinerja::find($id);

        if (!$IndikatorKinerja) {
            return response()->json([
                'message' => 'Indikator Kinerja tidak ditemukan.'
            ], 404);
        }

        // Validasi input
        $request->validate([
            'sasaran_strategis_id' => 'required|exists:sasaran_strategis,sasaran_strategis_id',
            'isi_indikator_kinerja' => 'required|string',
        ]);

        // Update data
        $IndikatorKinerja->sasaran_strategis_id = $request['sasaran_strategis_id'];
        $IndikatorKinerja->isi_indikator_kinerja = $request['isi_indikator_kinerja'];
        $IndikatorKinerja->save();

        $IndikatorKinerja->load('sasaranStrategis');

        return response()->json([
            'message' => 'Indikator Kinerja berhasil diupdate.',
            'data' => [
                'sasaran_strategis' => $IndikatorKinerja->sasaranStrategis->nama_sasaran ?? null,
                'isi_indikator_kinerja' => $IndikatorKinerja->isi_indikator_kinerja
            ]
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari data kriteria berdasarkan ID
        $IndikatorKinerja = IndikatorKinerja::find($id);

        if (!$IndikatorKinerja) {
            return response()->json([
                'message' => 'Indikator Kinerja tidak ditemukan.'
            ], 404);
        }

        // Hapus data kriteria
        $IndikatorKinerja->delete();

        return response()->json([
            'message' => 'Indikator Kinerja berhasil dihapus.'
        ]);
    }
}
