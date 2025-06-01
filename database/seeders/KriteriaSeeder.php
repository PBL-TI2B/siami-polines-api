<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kriteria')->insert([
            ['nama_kriteria' => 'Visi, Misi, Tujuan, Strategi'],
            ['nama_kriteria' => 'Tata kelola, Tata pamong, dan Kerjasama'],
            ['nama_kriteria' => 'Mahasiswa'],
            ['nama_kriteria' => 'Sumber Daya Manusia'],
            ['nama_kriteria' => 'Keuangan, Sarana, dan Prasarana'],
            ['nama_kriteria' => 'Pendidikan / Kurikulum dan Pembelajaran'],
            ['nama_kriteria' => 'Penelitian'],
            ['nama_kriteria' => 'Pengabdian Kepada Masyarakat'],
            ['nama_kriteria' => 'Luaran Tridharma'],
        ]);
        
    }
}
