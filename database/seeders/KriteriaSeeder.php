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
            ['nama_kriteria' => 'Kurikulum dan Pembelajaran'],
            ['nama_kriteria' => 'Penelitian'],
            ['nama_kriteria' => 'Luaran Tridharma'],
        ]);
        
    }
}
