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
            ['unit_kerja_id' => 1, 'nama_unit_kerja' => 'Admin', 'jenis_unit_id' => 1, 'parent_id' => null],
            ['unit_kerja_id' => 2, 'nama_unit_kerja' => 'UPA Layanan Uji Kompetensi', 'jenis_unit_id' => 1, 'parent_id' => null],
            ['unit_kerja_id' => 3, 'nama_unit_kerja' => 'UPA Pusat Teknologi Informasi dan Komunikasi', 'jenis_unit_id' => 1, 'parent_id' => null],
            ['unit_kerja_id' => 4, 'nama_unit_kerja' => 'UPA Perpustakaan', 'jenis_unit_id' => 1, 'parent_id' => null],
            ['unit_kerja_id' => 5, 'nama_unit_kerja' => 'UPA Pemeliharaan dan Perbaikan', 'jenis_unit_id' => 1, 'parent_id' => null],
            ['unit_kerja_id' => 6, 'nama_unit_kerja' => 'UPA Bahasa', 'jenis_unit_id' => 1, 'parent_id' => null],
            ['unit_kerja_id' => 7, 'nama_unit_kerja' => 'UPA Pengembangan Karir dan Kewirausahaan', 'jenis_unit_id' => 1, 'parent_id' => null],
            ['unit_kerja_id' => 8, 'nama_unit_kerja' => 'UPA Pengembangan Teknologi dan Produk Unggulan', 'jenis_unit_id' => 1, 'parent_id' => null],
            ['unit_kerja_id' => 9, 'nama_unit_kerja' => 'Bagian Akademik, Kemahasiswaan, Perencanaan, dan Kerjsama', 'jenis_unit_id' => 1, 'parent_id' => null],
            ['unit_kerja_id' => 10, 'nama_unit_kerja' => 'Bagian Umum dan Keuangan', 'jenis_unit_id' => 1, 'parent_id' => null],
            ['unit_kerja_id' => 11, 'nama_unit_kerja' => 'Koodirnator Kerjasama LN dan DN', 'jenis_unit_id' => 1, 'parent_id' => null],
            ['unit_kerja_id' => 12, 'nama_unit_kerja' => 'Jurusan Administrasi Bisnis', 'jenis_unit_id' => 2, 'parent_id' => null],
            ['unit_kerja_id' => 13, 'nama_unit_kerja' => 'Jurusan Teknik Sipil', 'jenis_unit_id' => 2, 'parent_id' => null],
            ['unit_kerja_id' => 14, 'nama_unit_kerja' => 'Jurusan Teknik Mesin', 'jenis_unit_id' => 2, 'parent_id' => null],
            ['unit_kerja_id' => 15, 'nama_unit_kerja' => 'Jurusan Teknik Elektro', 'jenis_unit_id' => 2, 'parent_id' => null],
            ['unit_kerja_id' => 16, 'nama_unit_kerja' => 'Jurusan Akuntansi', 'jenis_unit_id' => 2, 'parent_id' => null],
            ['unit_kerja_id' => 17, 'nama_unit_kerja' => 'Prodi Teknologi Rekayasa Komputer', 'jenis_unit_id' => 3, 'parent_id' => 15],
            ['unit_kerja_id' => 18, 'nama_unit_kerja' => 'Prodi Teknik Listrik', 'jenis_unit_id' => 3, 'parent_id' => 15],
            ['unit_kerja_id' => 19, 'nama_unit_kerja' => 'Prodi Teknik Elektronika', 'jenis_unit_id' => 3, 'parent_id' => 15],
            ['unit_kerja_id' => 20, 'nama_unit_kerja' => 'Prodi Teknik Telekomunikasi', 'jenis_unit_id' => 3, 'parent_id' => 15],
            ['unit_kerja_id' => 21, 'nama_unit_kerja' => 'Prodi Teknik Infokom', 'jenis_unit_id' => 3, 'parent_id' => 15],
            ['unit_kerja_id' => 22, 'nama_unit_kerja' => 'Prodi Teknik Rekayasa Instalasi Listrik', 'jenis_unit_id' => 3, 'parent_id' => 15],
            ['unit_kerja_id' => 23, 'nama_unit_kerja' => 'Prodi Teknik Rekayasa Elektronika', 'jenis_unit_id' => 3, 'parent_id' => 15],
            ['unit_kerja_id' => 24, 'nama_unit_kerja' => 'Prodi Teknik Telekomunikasi (STr)', 'jenis_unit_id' => 3, 'parent_id' => 15],
            ['unit_kerja_id' => 25, 'nama_unit_kerja' => 'Prodi Magister Telekomunikasi', 'jenis_unit_id' => 3, 'parent_id' => 15],
            ['unit_kerja_id' => 26, 'nama_unit_kerja' => 'Prodi Akuntansi', 'jenis_unit_id' => 3, 'parent_id' => 16],
            ['unit_kerja_id' => 27, 'nama_unit_kerja' => 'Prodi Keuangan dan Perbankan', 'jenis_unit_id' => 3, 'parent_id' => 16],
            ['unit_kerja_id' => 28, 'nama_unit_kerja' => 'Prodi Komputerisasi Akuntansi', 'jenis_unit_id' => 3, 'parent_id' => 16],
            ['unit_kerja_id' => 29, 'nama_unit_kerja' => 'Prodi Perbankan Syariah', 'jenis_unit_id' => 3, 'parent_id' => 16],
            ['unit_kerja_id' => 30, 'nama_unit_kerja' => 'Prodi Akuntansi Manajerial', 'jenis_unit_id' => 3, 'parent_id' => 16],
            ['unit_kerja_id' => 31, 'nama_unit_kerja' => 'Prodi Analisis Keuangan', 'jenis_unit_id' => 3, 'parent_id' => 16],
            ['unit_kerja_id' => 32, 'nama_unit_kerja' => 'Prodi Administrasi Bisnis', 'jenis_unit_id' => 3, 'parent_id' => 12],
            ['unit_kerja_id' => 33, 'nama_unit_kerja' => 'Prodi Manajemen Pemasaran', 'jenis_unit_id' => 3, 'parent_id' => 12],
            ['unit_kerja_id' => 34, 'nama_unit_kerja' => 'Prodi Administrasi Bisnis Terapan', 'jenis_unit_id' => 3, 'parent_id' => 12],
            ['unit_kerja_id' => 35, 'nama_unit_kerja' => 'Prodi Manajemen Bisnis Internasional', 'jenis_unit_id' => 3, 'parent_id' => 12],
            ['unit_kerja_id' => 36, 'nama_unit_kerja' => 'Prodi Kontruksi Sipil', 'jenis_unit_id' => 3, 'parent_id' => 13],
            ['unit_kerja_id' => 37, 'nama_unit_kerja' => 'Prodi Kontruksi Gedung', 'jenis_unit_id' => 3, 'parent_id' => 13],
            ['unit_kerja_id' => 38, 'nama_unit_kerja' => 'Prodi Perawatan dan Perbaikan Gedung', 'jenis_unit_id' => 3, 'parent_id' => 13],
            ['unit_kerja_id' => 39, 'nama_unit_kerja' => 'Prodi Perancangan Jalan dan Jembatan', 'jenis_unit_id' => 3, 'parent_id' => 13],
            ['unit_kerja_id' => 40, 'nama_unit_kerja' => 'Prodi Teknik Mesin', 'jenis_unit_id' => 3, 'parent_id' => 14],
            ['unit_kerja_id' => 41, 'nama_unit_kerja' => 'Prodi Teknik Energi', 'jenis_unit_id' => 3, 'parent_id' => 14],
            ['unit_kerja_id' => 42, 'nama_unit_kerja' => 'Prodi Teknik Mesin Produksi dan Perawatan', 'jenis_unit_id' => 3, 'parent_id' => 14],
            ['unit_kerja_id' => 43, 'nama_unit_kerja' => 'Prodi Teknik Rekayasa Pembangkit Energi', 'jenis_unit_id' => 3, 'parent_id' => 14],
            ['unit_kerja_id' => 100, 'nama_unit_kerja' => 'Belum diatur', 'jenis_unit_id' => 1, 'parent_id' => null],
        ]);
    }
}
