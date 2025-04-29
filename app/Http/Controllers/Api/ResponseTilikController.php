<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\ResponseTilik;
use Illuminate\Http\Request;

class ResponseTilikController extends Controller
{
    public function index()
    {
        return ResponseTilik::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'auditing_id' => 'required|numeric',
            'tilik_id' => 'required|numeric',
            'realisasi' => 'nullable|string',
            'standar_nasional' => 'nullable|string',
            'uraian_isian' => 'nullable|string',
            'akar_penyebab' => 'nullable|string',
            'rencana_perbaikan' => 'nullable|string',
        ]);

        $responseTilik = ResponseTilik::create($request->all());
        return response()->json($responseTilik, 201);
    }

    public function show($id)
    {
        $responseTilik = ResponseTilik::findOrFail($id);
        return response()->json($responseTilik);
    }

    public function update(Request $request, $id)
    {
        $responseTilik = ResponseTilik::findOrFail($id);

        $responseTilik->update($request->all());
        return response()->json($responseTilik);
    }

    public function destroy($id)
    {
        $responseTilik = ResponseTilik::findOrFail($id);
        $responseTilik->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
