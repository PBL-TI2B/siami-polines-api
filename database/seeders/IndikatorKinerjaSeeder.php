<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndikatorKinerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('indikator_kinerja')->insert([
            [
                'indikator_kinerja_id' => 1,
                'sasaran_strategis_id' => 1,
                'isi_indikator_kinerja' => 'Realisasi Pendapatan BLU Tahun 2022',
            ],
            [
                'indikator_kinerja_id' => 2,
                'sasaran_strategis_id' => 1,
                'isi_indikator_kinerja' => 'Persentase Penyelesaian Modernisasi Pengelolaan BLU',
            ],
            [
                'indikator_kinerja_id' => 3,
                'sasaran_strategis_id' => 2,
                'isi_indikator_kinerja' => 'Persentase Lulusan S1 dan D4/D3/D2 yang Berhasil Mendapat Pekerjaan, Melanjutkan Studi, atau Menjadi Wiraswasta.',
            ],
            [
                'indikator_kinerja_id' => 4,
                'sasaran_strategis_id' => 2,
                'isi_indikator_kinerja' => 'Persentase Mahasiswa S1 dan D4/D3/D2 yang Menghabiskan Paling Tidak 20 SKS di Luar Kampus atau Meraih Prestasi Paling Rendah Tingkat Nasional',
            ],
            [
                'indikator_kinerja_id' => 5,
                'sasaran_strategis_id' => 2,
                'isi_indikator_kinerja' => 'Persentase Mahasiswa S1 dan D4/D3/D2 yang Menghabiskan Paling Tidak 20 SKS di Luar Kampus.',
            ],
            [
                'indikator_kinerja_id' => 6,
                'sasaran_strategis_id' => 2,
                'isi_indikator_kinerja' => 'Persentase Dosen Tetap Berkualifikasi Akademik S3, Memiliki Sertifikasi Kompetensi/ Profesi yang Diakui Oleh Industri dan Dunia Kerja, atau Berasal dari Kalangan Praktisi Profesional, Dunia Industri, atau Dunia Kerja',
            ],
            [
                'indikator_kinerja_id' => 7,
                'sasaran_strategis_id' => 2,
                'isi_indikator_kinerja' => 'Persentase Dosen Tetap Memiliki Sertifikasi Kompetensi/ Profesi yang Diakui Oleh Industri dan Dunia Kerja.',
            ],
            [
                'indikator_kinerja_id' => 8,
                'sasaran_strategis_id' => 2,
                'isi_indikator_kinerja' => 'Jumlah Keluaran Penelitian dan Pengabdian Kepada Masyarakat yang Berhasil Mendapat Rekognisi Internasional atau Diterapkan Oleh Masyarakat Per Jumlah Dosen',
            ],
            [
                'indikator_kinerja_id' => 9,
                'sasaran_strategis_id' => 2,
                'isi_indikator_kinerja' => 'Jumlah Keluaran Penelitian dan Pengabdian Kepada Masyarakat yang Berhasil Mendapat Rekognisi Internasional.',
            ],
            [
                'indikator_kinerja_id' => 10,
                'sasaran_strategis_id' => 2,
                'isi_indikator_kinerja' => 'Jumlah Keluaran Penelitian dan Pengabdian Kepada Masyarakat yang Diterapkan Oleh Masyarakat Per Jumlah Dosen',
            ],
            [
                'indikator_kinerja_id' => 11,
                'sasaran_strategis_id' => 4,
                'isi_indikator_kinerja' => 'Persentase Prodi S1 dan D4/D3/D2 Yang Melaksanakan Kerjasama Dengan Mitra',
            ],
            [
                'indikator_kinerja_id' => 12,
                'sasaran_strategis_id' => 4,
                'isi_indikator_kinerja' => 'Persentase Mata Kuliah S1 dan D4/D3/D2 yang menggunakan Pemecahan Kasus  (case method) atau Pembelajaran Kelompok Berbasis Projek (project-based learning) Sebagai Sebagian Bobot Evaluasi.',
            ],
            [
                'indikator_kinerja_id' => 13,
                'sasaran_strategis_id' => 4,
                'isi_indikator_kinerja' => 'Persentase Program Studi S1 dan D4/D3/D2 yang Memiliki Akreditasi atau Sertifikasi  Internasional yang Diakui Pemerintah',
            ],
            [
                'indikator_kinerja_id' => 14,
                'sasaran_strategis_id' => 5,
                'isi_indikator_kinerja' => 'Rata-rata Nilai Kinerja Anggaran atas pelaksanaan RKA-K/L Satker minimal 93',
            ]
        ]);
    }
}
