<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\InstrumenResponse;
use App\Models\SetInstrumen;
use App\Models\Auditing; 
use App\Models\User; 
use App\Models\Role;
use App\Models\UnitKerja; 
use App\Models\Unsur; 
use App\Models\Kriteria; 
use App\Models\Deskripsi; 

class InstrumenResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $InstrumenResponse = InstrumenResponse::with([
            'auditing',
            'response',
            'setInstrumenUnitKerja',
            'auditing.auditee1.role',
            'auditing.auditee1.unitkerja',
            'setInstrumenUnitKerja.unsur.deskripsi.kriteria' // include relasi berantai agar eager loading optimal
        ])->get();

        return response()->json([
            'message' => 'Data Instrumen Response berhasil ditampilkan',
            'data' => $InstrumenResponse,
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
            'auditing_id' => 'required|exists:auditings,auditing_id',
            'set_instrumen_unit_kerja_id' => 'required|exists:set_instrumen,set_instrumen_unit_kerja_id',
            'response_id' => 'required|exists:responses,response_id',
            'status_instrumen' => 'required|string|max:100',
        ]);

        // Simpan data ke database
        $InstrumenResponse = new InstrumenResponse();
        $InstrumenResponse->auditing_id = $request['auditing_id'];
        $InstrumenResponse->set_instrumen_unit_kerja_id = $request['set_instrumen_unit_kerja_id'];
        $InstrumenResponse->response_id = $request['response_id'];
        $InstrumenResponse->status_instrumen = $request['status_instrumen'];
        $InstrumenResponse->save();

        // Load relasi untuk menghindari null atau lazy load error
        // $InstrumenResponse->load('auditing');
        // $InstrumenResponse->load('setInstrumenUnitKerja');
        // $InstrumenResponse->load('response');

        return response()->json([
            'message' => 'Instrumen Response berhasil ditambahkan.',
            'data' => [
                // 'auditing_status' => $InstrumenResponse->auditing->status ?? null,
                // 'set_instrumen_unit_kerja_id' => $InstrumenResponse->setInstrumenUnitKerja->set_instrumen_unit_kerja_id,
                // 'response_id' => $InstrumenResponse->response->response_id,
                'status_instrumen' => $InstrumenResponse->status_instrumen
            ]
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $InstrumenResponse = InstrumenResponse::find($id);

        if ($InstrumenResponse) {
            return response()->json($InstrumenResponse);
        } else {
            return response()->json([
                'message' => 'Instrumen Response tidak ditemukan.'
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
        $InstrumenResponse = InstrumenResponse::find($id);

        if (!$InstrumenResponse) {
            return response()->json([
                'message' => 'Instrumen Response tidak ditemukan.'
            ], 404);
        }

        // Validasi input
        $request->validate([
            'auditing_id' => 'required|exists:auditings,auditing_id',
            'set_instrumen_unit_kerja_id' => 'required|exists:set_instrumen,set_instrumen_unit_kerja_id',
            'response_id' => 'required|exists:responses,response_id',
            'status_instrumen' => 'required|string|max:100',
        ]);

        // Update data
        $InstrumenResponse->auditing_id = $request['auditing_id'];
        $InstrumenResponse->set_instrumen_unit_kerja_id = $request['set_instrumen_unit_kerja_id'];
        $InstrumenResponse->response_id = $request['response_id'];
        $InstrumenResponse->status_instrumen = $request['status_instrumen'];
        $InstrumenResponse->save();

        // $InstrumenResponse->load('auditing');
        // $InstrumenResponse->load('setInstrumenUnitKerja');
        // $InstrumenResponse->load('response');

         return response()->json([
            'message' => 'Instrumen Response berhasil ditambahkan.',
            'data' => [
                // 'auditing_status' => $InstrumenResponse->auditing->status ?? null,
                // 'set_instrumen_unit_kerja_id' => $InstrumenResponse->setInstrumenUnitKerja->set_instrumen_unit_kerja_id,
                // 'response_id' => $InstrumenResponse->response->response_id,
                'status_instrumen' => $InstrumenResponse->status_instrumen
            ]
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari data kriteria berdasarkan ID
        $InstrumenResponse = InstrumenResponse::find($id);

        if (!$InstrumenResponse) {
            return response()->json([
                'message' => 'Instrumen Response tidak ditemukan.'
            ], 404);
        }

        // Hapus data kriteria
        $InstrumenResponse->delete();

        return response()->json([
            'message' => 'Instrumen Response berhasil dihapus.'
        ]);
    }
}