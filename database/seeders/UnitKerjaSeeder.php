<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('unit_kerja')->insert([
            ['unit_kerja_id' => 1, 'nama_unit_kerja' => 'Admin', 'jenis_unit_id' => 1],
            ['unit_kerja_id' => 2, 'nama_unit_kerja' => 'UPT perpustakaan', 'jenis_unit_id' => 1],
            ['unit_kerja_id' => 3, 'nama_unit_kerja' => 'Jurusan Elktro', 'jenis_unit_id' => 2],
            ['unit_kerja_id' => 4, 'nama_unit_kerja' => 'Prodi Teknologi Rekayasa Komputer', 'jenis_unit_id' => 3],
            ['unit_kerja_id' => 100, 'nama_unit_kerja' => 'Belum diatur', 'jenis_unit_id' => 1],
        ]);
    }
}
