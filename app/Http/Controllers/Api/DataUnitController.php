<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JenisUnit;
use App\Models\UnitKerja;
use Illuminate\Http\Request;

class DataUnitController extends Controller
{
    public function store(Request $request, $unit) {
        $jenisUnit = JenisUnit::where('nama_jenis_unit', $unit)->first();

        if (!$jenisUnit) {
            return response()->json([
                'message' => 'Jenis unit tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'nama_unit_kerja' => 'required|string|max:255',
        ]);

        $unitKerja = UnitKerja::create([
            'nama_unit_kerja' => $request->nama_unit_kerja,
            'jenis_unit_id' => $jenisUnit->jenis_unit_id,
        ]);

        return response()->json([
            'message' => 'Unit Kerja berhasil dibuat',
            'data' => $unitKerja
        ], 201);
    }

    public function readAll() {
        $unitKerja = UnitKerja::with('jenisUnit')->get();
        return response()->json([
            'message' => 'Data unit kerja berhasil ditampilkan',
            'data' => $unitKerja,
        ], 200);
    }

    public function readByUnit($unit) {
        $jenisUnit = JenisUnit::where('nama_jenis_unit', $unit)->first();

        $unitKerja = UnitKerja::with('jenisUnit')->where('jenis_unit_id', $jenisUnit->jenis_unit_id)->get();
        return response()->json([
            'message' => 'Data unit kerja berhasil ditampilkan',
            'data' => $unitKerja,
        ], 200);
    }

    public function update(Request $request, $id) {
        $request -> validate([
            'nama_unit_kerja' => 'required|string|max:255',
        ]);

        $unitKerja = UnitKerja::find($id);

        if(!$unitKerja) {
            return response()->json([
                'message' => 'Unit kerja tidak ditemukan'
            ], 404);
        }

        if ($request->has('nama_unit_kerja')) {
            $unitKerja->nama_unit_kerja = $request->nama_unit_kerja;
        }

        $unitKerja->save();

        return response()->json([
            'message' => 'Unit kerja berhasil diperbarui'
        ], 200);
    }

    public function destroy($id) {
        $unitKerja = UnitKerja::find($id);

        if(!$unitKerja) {
            return response()->json([
                'message' => 'Unit kerja tidak ditemukan'
            ], 404);
        }

        $unitKerja->delete();
        return response()->json([
            'message' => 'Unit Kerja berhasil dihapus'
        ]);
    }
}
