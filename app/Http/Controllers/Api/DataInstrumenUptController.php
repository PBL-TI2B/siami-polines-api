<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SasaranStrategis;
use Illuminate\Http\Request;

class DataInstrumenUptController extends Controller
{
    public function index()
    {
        $data = SasaranStrategis::with([
            'indikatorKinerjas.aktivitas.setInstrumens.unitKerja'
        ])->get();

        return response()->json($data);
    }

    public function store(Request $request)
    {
        // Validasi data dasar
        $request->validate([
            'nama_sasaran' => 'required|string',
            'indikator_kinerjas' => 'required|array',
            'indikator_kinerjas.*.nama_indikator' => 'required|string',
            'indikator_kinerjas.*.aktivitas' => 'required|array',
            'indikator_kinerjas.*.aktivitas.*.nama_aktivitas' => 'required|string',
            'indikator_kinerjas.*.aktivitas.*.satuan' => 'required|string',
            'indikator_kinerjas.*.aktivitas.*.target' => 'required|numeric'
        ]);
        
        // Simpan Sasaran Strategis
        $sasaran = SasaranStrategis::create([
            'nama_sasaran' => $request->nama_sasaran
        ]);

        // Simpan Indikator dan seterusnya
        foreach ($request->indikator_kinerjas as $indikator) {
            $indikatorModel = $sasaran->indikatorKinerjas()->create([
                'isi_indikator_kinerja' => $indikator['isi_indikator_kinerja']
            ]);

            foreach ($indikator['aktivitas'] as $aktivitas) {
                $aktivitasModel = $indikatorModel->aktivitas()->create([
                    'nama_aktivitas' => $aktivitas['nama_aktivitas'],
                    'satuan' => $aktivitas['satuan'],
                    'target' => $aktivitas['target']
                ]);
            
                if (isset($aktivitas['set_instrumens'])) {
                    foreach ($aktivitas['set_instrumens'] as $instrumen) {
                        $aktivitasModel->setInstrumens()->create([
                            'unit_kerja_id' => $instrumen['unit_kerja_id']
                        ]);
                    }
                }
            }
        }

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $sasaran->load('indikatorKinerjas.aktivitas.setInstrumens.unitKerja')
        ], 201);
    }

    public function getData()
    {
        $data = SasaranStrategis::select(
            'sasaran_strategis.nama_sasaran as sasaran_strategis',
            'indikator_kinerja.isi_indikator_kinerja as indikator_kinerja',
            'aktivitas.nama_aktivitas as aktivitas',
            'aktivitas.satuan as satuan',
            'aktivitas.target as target_2022'
        )
        ->leftJoin('indikator_kinerja', 'sasaran_strategis.sasaran_strategis_id', '=', 'indikator_kinerja.sasaran_strategis_id')
        ->leftJoin('aktivitas', 'indikator_kinerja.indikator_kinerja_id', '=', 'aktivitas.indikator_kinerja_id')
        ->orderBy('sasaran_strategis.sasaran_strategis_id')
        ->orderBy('indikator_kinerja.indikator_kinerja_id')
        ->orderBy('aktivitas.aktivitas_id')
        ->get();

        return response()->json($data);
    }
}