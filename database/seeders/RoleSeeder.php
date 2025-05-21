<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->delete();

        DB::table('roles')->insert([
            ['role_id' => 1, 'nama_role' => 'Admin', 'prefix' => 'admin'],
            ['role_id' => 2, 'nama_role' => 'Auditor', 'prefix' => 'auditor'],
            ['role_id' => 3, 'nama_role' => 'Auditee', 'prefix' => 'auditee'],
            ['role_id' => 4, 'nama_role' => 'Kepala PMPP', 'prefix' => 'kepala-pmpp'],
            ['role_id' => 5, 'nama_role' => 'Admin Unit', 'prefix' => 'admin-unit'],
        ]);
    }
}
