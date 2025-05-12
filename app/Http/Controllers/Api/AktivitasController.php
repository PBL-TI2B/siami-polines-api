<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Aktivitas; 

class AktivitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Aktivitas = Aktivitas::all();
        return response()->json([
            'success' => true,
            'message' => 'List Data Aktivitas',
            'data' => $Aktivitas
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
            'indikator_kinerja_id' => 'required|exists:indikator_kinerja,indikator_kinerja_id',
            'nama_aktivitas' => 'required|string|max:200',
            'satuan' => 'required|string|max:100',
            'target' => 'required|int',
        ]);

        // Simpan data ke database
        $Aktivitas = new Aktivitas();
        $Aktivitas->indikator_kinerja_id = $request['indikator_kinerja_id'];
        $Aktivitas->nama_aktivitas = $request['nama_aktivitas'];
        $Aktivitas->satuan = $request['satuan'];
        $Aktivitas->target = $request['target'];
        $Aktivitas->save();

        // Load relasi untuk menghindari null atau lazy load error
        $Aktivitas->load('indikatorKinerja');

        return response()->json([
            'message' => 'Indikator Kinerja berhasil ditambahkan.',
            'data' => [
                'indikator_kinerja' => $Aktivitas->indikatorKinerja()->isi_indikator_kinerja ?? null,
                'nama_aktivitas' => $Aktivitas->nama_aktivitas,
                'satuan' => $Aktivitas->satuan,
                'target' => $Aktivitas->target
            ]
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Aktivitas = Aktivitas::find($id);

        if ($Aktivitas) {
            return response()->json($Aktivitas);
        } else {
            return response()->json([
                'message' => 'Aktivitas tidak ditemukan.'
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
        $Aktivitas = Aktivitas::find($id);

        if (!$Aktivitas) {
            return response()->json([
                'message' => 'Aktivitas tidak ditemukan.'
            ], 404);
        }

        // Validasi input
        $request->validate([
            'indikator_kinerja_id' => 'required|exists:indikator_kinerja,indikator_kinerja_id',
            'nama_aktivitas' => 'required|string|max:200',
            'satuan' => 'required|string|max:100',
            'target' => 'required|int',
        ]);

        // Update data
        $Aktivitas->indikator_kinerja_id = $request['indikator_kinerja_id'];
        $Aktivitas->nama_aktivitas = $request['nama_aktivitas'];
        $Aktivitas->satuan = $request['satuan'];
        $Aktivitas->target = $request['target'];
        $Aktivitas->save();

        $Aktivitas->load('indikatorKinerja');

        return response()->json([
            'message' => 'Aktivitas berhasil diupdate.',
            'data' => [
                'indikator_kinerja' => $Aktivitas->indikatorKinerja->isi_indikator_kinerja ?? null,
                'nama_aktivitas' => $Aktivitas->nama_aktivitas,
                'satuan' => $Aktivitas->satuan,
                'target' => $Aktivitas->target
            ]
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari data kriteria berdasarkan ID
        $Aktivitas = Aktivitas::find($id);

        if (!$Aktivitas) {
            return response()->json([
                'message' => 'Aktivitas tidak ditemukan.'
            ], 404);
        }

        // Hapus data kriteria
        $Aktivitas->delete();

        return response()->json([
            'message' => 'Aktivitas berhasil dihapus.'
        ]);
    }
}
