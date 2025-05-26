<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SasaranStrategisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('sasaran_strategis')->insert([
            [
                'sasaran_strategis_id' => 1,
                'nama_sasaran' => 'Kinerja Pengelolaan keuangan Efektif, Efisien, dan Akuntabel'
            ],
            [
                'sasaran_strategis_id' => 2,
                'nama_sasaran' => 'Meningkatnya kualitas lulusan pendidikan tinggi',
            ],
            [
                'sasaran_strategis_id' => 3,
                'nama_sasaran' => 'Meningkatnya kualitas dosen pendidikan tinggi.',
            ],
            [
                'sasaran_strategis_id' => 4,
                'nama_sasaran' => 'Meningkatnya kualitas kurikulum dan pembelajaran',
            ],
            [
                'sasaran_strategis_id' => 5,
                'nama_sasaran' => 'Meningkatnya tata kelola satuan kerja di lingkungan Ditjen Pendidikan Vokasi',
            ],
            [
                'sasaran_strategis_id' => 6,
                'nama_sasaran' => 'Meningkatnya kualitas penelitian dan pengabdian kepada masyarakat',
            ],
            [
                'sasaran_strategis_id' => 7,
                'nama_sasaran' => 'Meningkatnya kualitas layanan pendidikan tinggi',
            ],
            [
                'sasaran_strategis_id' => 8,
                'nama_sasaran' => 'Meningkatnya kualitas tata kelola kelembagaan pendidikan tinggi',
            ],
        ]);
        
    }
}
