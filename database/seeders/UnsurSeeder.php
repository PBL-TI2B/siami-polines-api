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
        DB::table('unsur')->insert([
            ['deskripsi_id' => 1 ,'isi_unsur' =>    '1. Renstra Polines
                                                    2. Renstra Jurusan/Prodi 
                                                    3. Renop Jurusan /prodi
                                                    4. Dokumen Visi Keilmuan (Keunikan Prodi)
                                                    5. Dokumen  Implemenntasi'],
            ['deskripsi_id' => 2 ,'isi_unsur' =>    '1. 1. Dokumen Mekanisme VTMS 
                                                    2. Dokumen DukunganVTMS dari
                                                    Pihak Pemangku Kepentingan'],
            ['deskripsi_id' => 3 ,'isi_unsur' =>    '1. Dokumen Strategi 
                                                    2. Dokumen DukunganVTMS dari  Pihak Pemangku Kepentingan 
                                                    3. Dokumentasi Implementasi Strategi'],
            ['deskripsi_id' => 4 ,'isi_unsur' =>    '1. Dokumen SK pengangkatan pimpinan jurusan/prodi
                                                    2. Adanya dokumen Tupoksi untuk setiap jabatan di semua unit di Polines
                                                    4.Adanya pedoman ataupun kode etik karyawan ( dosen, tendik, administrasi, mahasiswa )'],
        ]);
        
    }
}
