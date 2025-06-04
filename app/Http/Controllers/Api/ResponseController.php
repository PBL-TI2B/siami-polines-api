<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class ResponseController extends Controller
{

    public function index()
    {
        try {
            $responses = Response::with(['auditing', 'setInstrumen'])->get();
            return response()->json([
                'success' => true,
                'message' => 'List Data Response',
                'data' => $responses
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve responses: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created response in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'auditing_id' => 'required|exists:auditings,auditing_id',
            'set_instrumen_unit_kerja_id' => 'required|exists:set_instrumen,set_instrumen_unit_kerja_id',
            'ketersediaan_standar_dan_dokumen' => 'nullable|string',
            'spt_pt' => 'nullable|string',
            'sn_dikti' => 'nullable|string',
            'lokal' => 'nullable|string',
            'nasional' => 'nullable|string',
            'internasional' => 'nullable|string',
            'capaian' => 'nullable|string',
            'sesuai' => 'nullable|string',
            'lokasi_bukti_dukung' => 'nullable|string',
            'minor' => 'nullable|integer',
            'mayor' => 'nullable|integer',
            'ofi' => 'nullable|integer',
            'keterangan' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $response = Response::create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Response created successfully',
                'data' => $response->load(['auditing', 'setInstrumen'])
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create response: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified response.
     */
    public function show($id)
    {
        try {
            $response = Response::with(['auditing', 'setInstrumen'])->findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Response details',
                'data' => $response
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Response not found or error: ' . $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified response in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'auditing_id' => 'required|exists:auditings,auditing_id',
            'minor' => 'nullable|integer',
            'mayor' => 'nullable|integer',
            'ofi' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $response = Response::findOrFail($id);
            $response->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Response updated successfully',
                'data' => $response->load(['auditing', 'setInstrumen'])
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update response: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified response from storage.
     */
    public function destroy($id)
    {
        try {
            $response = Response::findOrFail($id);
            $response->delete();
            return response()->json([
                'success' => true,
                'message' => 'Response deleted successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete response: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Retrieve responses by auditing ID.
     */
    public function getByAuditingId($auditing_id)
    {
        try {
            $responses = Response::with(['auditing', 'setInstrumen'])
                ->where('auditing_id', $auditing_id)
                ->get();

            if ($responses->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No responses found for the given auditing ID'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Responses retrieved successfully',
                'data' => $responses
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve responses: ' . $e->getMessage()
            ], 500);
        }
    }
}
