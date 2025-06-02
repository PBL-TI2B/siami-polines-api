<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanPtpp;

class LaporanPtppController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $laporan = LaporanPtpp::all();
        return response()->json([
            'status' => 'success',
            'data' => $laporan
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
        $validator = Validator::make($request->all(), [
            'standar' => 'required|string|max:255',
            'uraian_temuan' => 'required|string',
            'kategori_temuan' => 'required|in:NC,AOC,OFI',
            'saran_perbaikan' => 'nullable|string',
            'status' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $laporan = LaporanPtpp::create($request->all());
        return response()->json([
            'status' => 'success',
            'data' => $laporan
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show ($id)
    {
        $laporan = LaporanPtpp::find($id);
        if (!$laporan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Laporan not found'
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'data' => $laporan
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $laporan = LaporanPtpp::find($id);
        if (!$laporan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Laporan not found'
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'data' => $laporan
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $laporan = LaporanPtpp::find($id);
        if (!$laporan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Laporan not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'standar' => 'sometimes|string|max:255',
            'uraian_temuan' => 'sometimes|string',
            'kategori_temuan' => 'sometimes|in:NC,AOC,OFI',
            'saran_perbaikan' => 'nullable|string',
            'status' => 'sometimes|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $laporan->update($request->all());
        return response()->json([
            'status' => 'success',
            'data' => $laporan
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $laporan = LaporanPtpp::find($id);
        if (!$laporan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Laporan not found'
            ], 404);
        }

        $laporan->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Laporan deleted successfully'
        ], 200);
    }
}
