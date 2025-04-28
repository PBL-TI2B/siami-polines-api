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
            ['nomor' => 1, 'nama_kriteria' => 'Visi, Misi, Tujuan, Strategi'],
            ['nomor' => 2, 'nama_kriteria' => 'Tata kelola, Tata pamong, dan Kerjasama'],
            ['nomor' => 4, 'nama_kriteria' => ''], // Menggunakan NULL jika kolom bisa null
            ['nomor' => 5, 'nama_kriteria' => ''],
            ['nomor' => 6, 'nama_kriteria' => 'Kurikulum dan Pembelajaran'],
            ['nomor' => 7, 'nama_kriteria' => 'Penelitian'],
            ['nomor' => 8, 'nama_kriteria' => ''],
            ['nomor' => 9, 'nama_kriteria' => 'Luaran Tridharma'],
        ]);
        
    }
}
