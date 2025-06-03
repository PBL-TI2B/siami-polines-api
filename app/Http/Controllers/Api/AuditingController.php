<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Auditing;
use App\Models\User;

class AuditingController extends Controller
{
    public function index()
    {
        $auditings = Auditing::with([
        'auditor1',
        'auditor2',
        'auditee1',
        'auditee2',
        'unitKerja',
        'periode',
        ])->get();
        return response()->json($auditings);
    }

    public function getByUserLogin($userId)
    {
        $user = User::where('user_id', $userId)->first();
        if (!$user) {
            return response()->json([
                'message' => 'User tidak ditemukan',
                'data' => [],
            ], 404);
        }

        $userID = $user->user_id;

        $auditings = Auditing::with('auditor1', 'auditor2', 'auditee1', 'auditee2', 'unitKerja', 'periode')
                ->where('user_id_1_auditor', $userID)
                ->orWhere('user_id_2_auditor', $userID)
                ->orWhere('user_id_1_auditee', $userID)
                ->orWhere('user_id_2_auditee', $userID)->get();

        return response()->json([
            'message' => 'Data Auditing per user berhasil diambil',
            'data' => $auditings,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id_1_auditor' => 'required|integer',
            'user_id_2_auditor' => 'nullable|integer',
            'user_id_1_auditee' => 'required|integer',
            'user_id_2_auditee' => 'nullable|integer',
            'unit_kerja_id' => 'required|integer',
            'periode_id' => 'required|integer',
            'jadwal_audit' => 'nullable|date',
            'status' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $auditing = Auditing::create([
            'user_id_1_auditor' => $request->user_id_1_auditor,
            'user_id_2_auditor' => $request->user_id_2_auditor,
            'user_id_1_auditee' => $request->user_id_1_auditee,
            'user_id_2_auditee' => $request->user_id_2_auditee,
            'unit_kerja_id' => $request->unit_kerja_id,
            'periode_id' => $request->periode_id,
            'jadwal_audit' => $request->jadwal_audit,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Data auditing berhasil ditambahkan.',
            'data' => $auditing
        ]);
    }

    public function show($id)
    {
        $auditing = Auditing::find($id);
        if (!$auditing) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }
        return response()->json($auditing);
    }

    public function update(Request $request, $id)
    {
        $auditing = Auditing::find($id);
        if (!$auditing) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'user_id_1_auditor' => 'nullable|integer',
            'user_id_2_auditor' => 'nullable|integer',
            'user_id_1_auditee' => 'nullable|integer',
            'user_id_2_auditee' => 'nullable|integer',
            'unit_kerja_id' => 'nullable|integer',
            'jadwal_audit' => 'nullable|date',
            'status' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $auditing->update($request->all());

        return response()->json([
            'message' => 'Data auditing berhasil diperbarui.',
            'data' => $auditing
        ]);
    }

    public function destroy($id)
    {
        $auditing = Auditing::find($id);
        if (!$auditing) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }

        $auditing->delete();

        return response()->json(['message' => 'Data auditing berhasil dihapus.']);
    }
}
