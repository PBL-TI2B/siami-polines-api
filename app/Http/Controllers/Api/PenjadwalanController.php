<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Auditing;
use App\Models\PeriodeAudit;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Http\Request;

class PenjadwalanController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'auditor_1' => 'required|string',
            'auditor_2' => 'required|string',
            'auditee_1' => 'required|string',
            'auditee_2' => 'required|string',
            'unit_kerja' => 'required|string',
            'jadwal_audit' => 'required|date',
            'status' => 'nullable|string'
        ]);

        $user1Auditor = User::where('nama', $request->auditor_1)->first();
        $user2Auditor = User::where('nama', $request->auditor_2)->first();
        $user1Auditee = User::where('nama', $request->auditee_1)->first();
        $user2Auditee = User::where('nama', $request->auditee_2)->first();

        if (!$user1Auditor || !$user1Auditee || !$user2Auditor || !$user2Auditee) {
            return response()->json([
                'message' => 'Nama auditor atau auditee tidak ditemukan',
            ], 404);
        }

        $unitKerja = UnitKerja::where('nama_unit_kerja', $request->unit_kerja)->first();
        if (!$unitKerja) {
            return response()->json([
                'message' => 'Nama unit kerja tidak ditemukan',
            ], 404);
        }

        $periode = PeriodeAudit::where('status', 'Sedang Berjalan')->first();
        if (!$periode) {
            return response()->json([
                'message' => 'Tidak ada periode yang sedang berjalan',
            ], 404);
        }

        $penjadwalan = Auditing::create([
            'user_id_1_auditor' => $user1Auditor->user_id,
            'user_id_2_auditor' => $user2Auditor->user_id,
            'user_id_1_auditee' => $user1Auditee->user_id,
            'user_id_2_auditee' => $user2Auditee->user_id,
            'unit_kerja_id' => $unitKerja->unit_kerja_id,
            'periode_id' => $periode->periode_id,
            'jadwal_audit' => $request->jadwal_audit,
            'status' => $request->status ?? 'diserahkan',
        ]);

        return response()->json([
            'message' => 'Audit berhasil dijadwalkan',
            'data' => $penjadwalan
        ], 201);
    }

    public function readAll() {
        $jadwalAudit = Auditing::with('unitKerja', 'periode')->get();
        return response()->json([
            'message' => 'Data Jadwal Audit berhasil ditampilkan',
            'data' => $jadwalAudit
        ], 200);
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'auditor_1' => 'nullable|string',
            'auditor_2' => 'nullable|string',
            'auditee_1' => 'nullable|string',
            'auditee_2' => 'nullable|string',
            'unit_kerja' => 'nullable|string',
            'jadwal_audit' => 'nullable|date',
            'status' => 'nullable|string'
        ]);

        $auditing = Auditing::find($id);
        if (!$auditing) {
            return response()->json(['message' => 'Data auditing tidak ditemukan'], 404);
        }

        $data = [];

        if ($request->filled('auditor_1')) {
            $user = User::where('nama', $request->auditor_1)->first();
            if (!$user) return response()->json(['message' => 'Auditor 1 tidak ditemukan'], 404);
            $data['user_id_1_auditor'] = $user->user_id;
        }

        if ($request->filled('auditor_2')) {
            $user = User::where('nama', $request->auditor_2)->first();
            if (!$user) return response()->json(['message' => 'Auditor 2 tidak ditemukan'], 404);
            $data['user_id_2_auditor'] = $user->user_id;
        }

        if ($request->filled('auditee_1')) {
            $user = User::where('nama', $request->auditee_1)->first();
            if (!$user) return response()->json(['message' => 'Auditee 1 tidak ditemukan'], 404);
            $data['user_id_1_auditee'] = $user->user_id;
        }

        if ($request->filled('auditee_2')) {
            $user = User::where('nama', $request->auditee_2)->first();
            if (!$user) return response()->json(['message' => 'Auditee 2 tidak ditemukan'], 404);
            $data['user_id_2_auditee'] = $user->user_id;
        }

        if ($request->filled('unit_kerja')) {
            $unitKerja = UnitKerja::where('nama_unit_kerja', $request->unit_kerja)->first();
            if (!$unitKerja) return response()->json(['message' => 'Unit kerja tidak ditemukan'], 404);
            $data['unit_kerja_id'] = $unitKerja->unit_kerja_id;
        }

        if ($request->filled('jadwal_audit')) {
            $data['jadwal_audit'] = $request->jadwal_audit;
        }

        if ($request->filled('status')) {
            $data['status'] = $request->status;
        }

        $auditing->update($data);

        return response()->json([
            'message' => 'Data auditing berhasil diperbarui',
            'data' => $auditing->fresh()
        ], 200);
    }

    public function delete() {
        Auditing::query()->delete();

        return response()->json([
            'message' => 'seluruh data auditing berhasil dihapus'
        ]);
    }
}
