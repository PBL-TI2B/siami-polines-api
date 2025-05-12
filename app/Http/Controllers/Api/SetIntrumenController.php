<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SetInstrumen;
use Illuminate\Http\Request;

class SetIntrumenController extends Controller
{
    public function store(Request $request) {
        try {
            $request->validate([
                'unit_kerja_id' => 'required|integer|exists:unit_kerja,unit_kerja_id',
                'aktivitas_id' => 'required|integer|exists:aktivitas,aktivitas_id',
                'unsur_id' => 'required|integer|exists:unsur,unsur_id',
            ]);

            $setInstrumen = SetInstrumen::create([
                'unit_kerja_id' => $request->unit_kerja_id,
                'aktivitas_id' => $request->aktivitas_id,
                'unsur_id' => $request->unsur_id,
            ]);

            return response()->json([
                'message' => 'Set Instrumen berhasil diupload',
                'data' => $setInstrumen
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function readAll() {
        $setInstrumen = SetInstrumen::with('unitKerja', 'aktivitas', 'unsur')->get();
        return response()->json([
            'message' => 'Data SetInstrumen berhasil ditampilkan',
            'data' => $setInstrumen,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'unit_kerja_id' => 'nullable|integer|exists:unit_kerja,unit_kerja_id',
                'aktivitas_id' => 'nullable|integer|exists:aktivitas,aktivitas_id',
                'unsur_id' => 'nullable|integer|exists:unsur,unsur_id',
            ]);

            $setInstrumen = SetInstrumen::where('set_instrumen_unit_kerja_id', $id)->first();
            if (!$setInstrumen) {
                return response()->json(['message' => 'Data auditing tidak ditemukan'], 404);
            }

            $setInstrumen->update([
                'unit_kerja_id' => $request->unit_kerja_id,
                'aktivitas_id' => $request->aktivitas_id,
                'unsur_id' => $request->unsur_id,
            ]);

            return response()->json([
                'message' => 'Set Instrumen berhasil diperbarui',
                'data' => $setInstrumen
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id) {
        $setInstrumen = SetInstrumen::where('set_instrumen_unit_kerja_id', $id)->first();

        if(!$setInstrumen) {
            return response()->json([
                'message' => 'Instrumen tidak ditemukan'
            ], 404);
        }

        $setInstrumen->delete();
        return response()->json([
            'message' => 'Instrumen berhasil dihapus'
        ]);
    }
}
