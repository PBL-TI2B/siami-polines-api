<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AktivitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         DB::table('aktivitas')->insert([
            [
                'aktivitas_id' => 1,
                'indikator_kinerja_id' => 1,
                'nama_aktivitas' => 'Persiapan pembukaan Prodi Baru',
                'satuan'=>'Dokumen',
                'target'=>'1',
            ],
            [
                'aktivitas_id' => 2,
                'indikator_kinerja_id' => 1,
                'nama_aktivitas' => 'Prodi Baru MST',
                'satuan'=>'Prodi',
                'target'=>'1',
            ],
            [
                'aktivitas_id' => 3,
                'indikator_kinerja_id' => 2,
                'nama_aktivitas' => 'Pemutakhiran/Digitalisasi Data',
                'satuan'=>'Data',
                'target'=> '6',
            ],
            [
                'aktivitas_id' => 4,
                'indikator_kinerja_id' => 2,
                'nama_aktivitas' => 'Penataan jaringan data',
                'satuan'=>'Jaringan',
                'target'=>'1',
            ],
            [
                'aktivitas_id' => 5,
                'indikator_kinerja_id' => 3,
                'nama_aktivitas' => 'Kompetensi Mahasiswa',
                'satuan'=>'mahasiswa',
                'target'=>'-',
            ],
            [
                'aktivitas_id' => 6,
                'indikator_kinerja_id' => 5,
                'nama_aktivitas' => 'Supervisi Magang',
                'satuan'=>'Supervisi',
                'target'=>'0',
            ],
            [
                'aktivitas_id' => 7,
                'indikator_kinerja_id' => 5,
                'nama_aktivitas' => 'Pengadaan/Penyusunan/ Pengembangan Perangkat PBM',
                'satuan'=>'Dokumen',
                'target'=>'8',
            ],
            [
                'aktivitas_id' => 8,
                'indikator_kinerja_id' => 7,
                'nama_aktivitas' => 'Peningkatan kompetensi dosen/Sertifikasi Kompetensi',
                'satuan'=>'Dosen',
                'target'=>'20',
            ],
            [
                'aktivitas_id' => 9,
                'indikator_kinerja_id' => 9,
                'nama_aktivitas' => 'Penguatan Jurnal Ilmiah',
                'satuan'=>'Jurnal Terakreditasi',
                'target'=>'3',
            ],
            [
                'aktivitas_id' => 10,
                'indikator_kinerja_id' => 9,
                'nama_aktivitas' => 'Optimalisasi KBK',
                'satuan'=>'Dokumen',
                'target'=>'6',
            ],
            [
                'aktivitas_id' => 11,
                'indikator_kinerja_id' => 10,
                'nama_aktivitas' => 'Seminar Nasional',
                'satuan'=>'Seminar',
                'target'=>'1',
            ],
            [
                'aktivitas_id' => 12,
                'indikator_kinerja_id' => 11,
                'nama_aktivitas' => 'Pemeliharaan Kerjasama Mitra/Industri',
                'satuan'=>'PKS',
                'target'=>'1',
            ],
            [
                'aktivitas_id' => 13,
                'indikator_kinerja_id' => 12,
                'nama_aktivitas' => 'Revisi/Pengembangan kurikulum',
                'satuan'=>'Prodi',
                'target'=>'6',
            ],
            [
                'aktivitas_id' => 14,
                'indikator_kinerja_id' => 12,
                'nama_aktivitas' => 'Pengembangan laboratorium/bengkel/workshop',
                'satuan'=>'Lab',
                'target'=>'0',
            ],
            [
                'aktivitas_id' => 15,
                'indikator_kinerja_id' => 13,
                'nama_aktivitas' => 'Penyusunan Evaluasi Diri dan LPKS',
                'satuan'=>'Prodi',
                'target'=>'2',
            ],
            [
                'aktivitas_id' => 16,
                'indikator_kinerja_id' => 13,
                'nama_aktivitas' => 'Borang akreditasi',
                'satuan'=>'Prodi',
                'target'=>'0',
            ],
            [
                'aktivitas_id' => 17,
                'indikator_kinerja_id' => 13,
                'nama_aktivitas' => 'Penyusunan Laporan Akreditasi Internasional',
                'satuan'=>'Dokumen',
                'target'=>'1',
            ],
            [
                'aktivitas_id' => 18,
                'indikator_kinerja_id' => 14,
                'nama_aktivitas' => 'Rapat Kerja',
                'satuan'=>'Dokumen',
                'target'=>'1',
            ],
            [
                'aktivitas_id' => 19,
                'indikator_kinerja_id' => 14,
                'nama_aktivitas' => 'Tata kelola : Gugus Kendali Mutu',
                'satuan'=>'Dokumen Risalah',
                'target'=>'1',
            ], 
         ]);
    }
}
