<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UnsurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('unsur')->insert([
            ['deskripsi_id' => 1 ,'isi_unsur' => <<<EOT
1. Renstra Polines
2. Renstra Jurusan/Prodi
3. Renop Jurusan/Prodi
4. Dokumen Visi Keilmuan (Keunikan Prodi)
5. Dokumen Implementasi
EOT
],
            ['deskripsi_id' => 2 ,'isi_unsur' => <<<EOT
1. Dokumen Mekanisme VTMS 
2. Dokumen DukunganVTMS dari
Pihak Pemangku Kepentingan 
EOT
],
            ['deskripsi_id' => 3 ,'isi_unsur' => <<<EOT
1. Dokumen Strategi 
2. Dokumen DukunganVTMS dari  Pihak Pemangku Kepentingan 
3. Dokumentasi Implementasi Strategi
EOT
],
            ['deskripsi_id' => 4 ,'isi_unsur' => <<<EOT
1. Keberadaan Statuta Polines dan dokumennya
2. Dokumen Susunan Organisasi dan Tata Kerja (SOTK)
3. Adanya dokumen Tupoksi untuk setiap jabatan di semua unit di Polines
4.Adanya pedoman ataupun kode etik karyawan ( dosen, tendik, administrasi, mahasiswa )
EOT
],
            ['deskripsi_id' => 5 ,'isi_unsur' => <<<EOT
1. Dokumen SK pengangkatan pimpinan jurusan/prodi
2. Adanya dokumen Tupoksi untuk setiap jabatan di semua unit di Polines
4.Adanya pedoman ataupun kode etik karyawan (dosen, tendik, administrasi, mahasiswa)
EOT
],
            ['deskripsi_id' => 6 ,'isi_unsur' => <<<EOT
'1. Dokumen SOP  Pelaksanaan Kegiatan
3.SOP Kegiatan
4. Dok. Laporan Kegiatan
6. Adanya Dokumen 
5. Adanya pedoman proposal dan pelaporan kegiatan
EOT
],
            ['deskripsi_id' => 7 ,'isi_unsur' => <<<EOT
'1. Adanya Dokumen Penjaminan Mutu Pendidikan 
2. Dokumen Sistem Penjamin Mutu Internal 
2. Dokumen Hasil Audit Mutu Internal
3. DokumenTindak lanjut perbaikan mutu
EOT
],
            ['deskripsi_id' => 8 ,'isi_unsur' => <<<EOT
1. Adanya dokumen kerjasama Polines dengan pihak eksternal
2. Dokumen Jumlah Kerjasama Internasional 
3. Dokumen pelaksanaan kerjasama MOA
4. Bukti kerjasam bidang pendidikan, Penelitian dan PKM
EOT
],
            ['deskripsi_id' => 9 ,'isi_unsur' => <<<EOT
1. Data Hasil Kersama dan tindak lanjutnya
2. Dokumen kerjasama berkelanjutan yang telah dilaksanakan serta hasil evaluasi dan manfaatnya.
EOT
],
            ['deskripsi_id' => 10 ,'isi_unsur' => <<<EOT
1.Sistem Penerimaan 
a.Sistem Rekruitmen
b. Mutu, Alses kecukupan layanan mahasiswa
c. Upaya Peningkatan animo calon mahasiswa di level lokal, Nasional, Internasional
EOT
],
            ['deskripsi_id' => 10 ,'isi_unsur' => '1) Dokumen profil mahasiswa.'],
            ['deskripsi_id' => 10 ,'isi_unsur' => '2) Dokumen SOP pengajuan beasiswa dan magang.'],
            ['deskripsi_id' => 10 ,'isi_unsur' => '3) Dokumen terkait layanan dan fasilitas kemahasiswaan.'],
            ['deskripsi_id' => 10 ,'isi_unsur' => '4) Dokumen konsultasi bimbingan akademik dan tugas akhir.'],
            ['deskripsi_id' => 10 ,'isi_unsur' => '5) Dokumen kebijakan dan prosedur penerimaan mahasiswa.'],
            ['deskripsi_id' => 10 ,'isi_unsur' => '6) Dokumen pengembangan kompetensi mahasiswa.'],
            ['deskripsi_id' => 10 ,'isi_unsur' => '7) Dokumen pedoman non-akademik mahasiswa.'],
            ['deskripsi_id' => 10 ,'isi_unsur' => '8) Dokumen Evaluasi Mahasiswa dan kepuasan mahasiswa terhadp layanan akademik.'],
            ['deskripsi_id' => 10 ,'isi_unsur' => '9. Dokumen Tindak lanjut dan implementasi hasil evaluasi ketercapaian standar.'],
            ['deskripsi_id' => 11 ,'isi_unsur' => <<<EOT
1) Data profil dosen tetap dan tenaga kependidikan. 
2) Data profil dosen tidak tetap
3.) Kebijakan Pengembangan Dosen Tetap dan tenaga Kependidiknan
4) Kebijakan doen industri
Kebijakan pengakukan/rekognisi/ prestasi/kenerja di level Nasional/Internasional
EOT
],
            ['deskripsi_id' => 12 ,'isi_unsur' => '1) Dokumen  EWMP'],
            ['deskripsi_id' => 12 ,'isi_unsur' => '2) Bukti kegiatan dosen insdustri'],
            ['deskripsi_id' => 12 ,'isi_unsur' => '3) Bukti Pengakuan/rekoqnisi/kepakaran/ prestasi/ienerja dosen'],
            ['deskripsi_id' => 13 ,'isi_unsur' => <<<EOT
1) Dokumen people planning and development dosen dan tenaga kependidikan
2) Bukti sahih  pengembangan dosen dan tenaga kependidkan
EOT
],
            ['deskripsi_id' => 14 ,'isi_unsur' => '1) Bukti Evaluasi Tingkat Kepuasan dosen oleh mahasiswa/pengguna'],
            ['deskripsi_id' => 14 ,'isi_unsur' => '2) Bukti Evaluasi Tingkat Kepuasan Tenaga Kependidikan oleh mahasiswa/pengguna'],
            ['deskripsi_id' => 14 ,'isi_unsur' => '3) Dokumen Tindak Lanjut dan Implementasi terhadap hasil evaluasi ketercapaian standar SDM'],
            ['deskripsi_id' => 15 ,'isi_unsur' => <<<EOT
1)Dokumen  Rencana kerja dan anggaran tahunan.
2) Dokumen Laporan realisasi keuangan tahunan.
3) Ketersediaan  Pembiayaan Pembelajaran sesuai SN-Dikti
4)  Ketersediaan  Pendanaan dan Pembiayaan Penelitian,  sesuai SN-Dikti
5) Ketersediaan  Standar Pendanaan dan Pembiayaan PkM, sesuai SN-Dikti
EOT
],
            ['deskripsi_id' => 16 ,'isi_unsur' => <<<EOT
1) Dokumentasi jumlah dan kondisi sarana dan prasarana baik fisik maupun  virtual . 
2)  Ketersediaan   Sarpras untuk Pembelajaran, sesuai SN-Dikti
3) Ketersediaan  Sarpras untuk Penelitian, sesuai SN-Dikti
4 )Ketersediaan Sarpras untuk PkM.  sesuai, SN-Dikti
5) Ketersedian Sistem Informasi dan Komunikasi  dan Aplikasi pembelajaran
7) Ketersediaan  sarana/prasarana ibadah, olahraga, balai pengobatan 
4)Ketersediaan  sarana/prasarana bagi penyandang disabilitas
EOT
],
            ['deskripsi_id' => 17 ,'isi_unsur' => <<<EOT
1) Dokumen evaluasi kepuasan dosen, tenaga kependidikan dan mahasiswa terhadap ketersediaan dan keteraksesan sarana prasarana
2) dokumen tindak lanjut dan implementasi terhadap hasil evaluasi ketercapaian standar (IKU dan IKT) yang  berkaitan dengan keuangan, sarana, dan prasarana.
EOT
],
            ['deskripsi_id' => 18 ,'isi_unsur' => <<<EOT
a). Profil lulusan, capaian pembelajaran lulusan (CPL) sesuai dengan profil Lulusan dan jenjang KKNI/SKKNI.
b). Ketersediaan Struktur Kurikulum berbasis KKNI/OBE/SKKNI sesuai dengan Profil Lulusan,
c) RPS, Struktur Mata Kuliah dan Asesmen Pembelajaran. 
d). Ketersediaan Kebijakan terkait penciptaan suasana akademik
EOT
],
            ['deskripsi_id' => 19 ,'isi_unsur' => '1) Dokumen terkait capaian pembelajaran.'],
            ['deskripsi_id' => 20 ,'isi_unsur' => '2) Dokumen kurikulum.'],
            ['deskripsi_id' => 21 ,'isi_unsur' => '3) Dokumen pedoman akademik mahasiswa.'],
            ['deskripsi_id' => 22 ,'isi_unsur' => '4) Dokumen hasil pembahasan kurikulum dengan semua pemangku kepentingan (pimpinan UPPS, dosen PS, mahasiswa, alumni, industri).'],
            ['deskripsi_id' => 23 ,'isi_unsur' => '5) Dokumen hasil pengembangan, implementasi, dan evaluasi kurikulum.'],
            ['deskripsi_id' => 23 ,'isi_unsur' => '6) Dokumen jaminan pembelajaran.'],
            ['deskripsi_id' => 23 ,'isi_unsur' => '7) Dokumen hasil pengukuran capaian pembelajaran.'],
            ['deskripsi_id' => 23 ,'isi_unsur' => '8) Dokumen tracer study dan survei pemangku kepentingan.'],
            ['deskripsi_id' => 24 ,'isi_unsur' => <<<EOT
1) Dokumen Pengelolaan Penelitian yang lengkap (Roadmap, Renstra Penelitian, RIP Penelitian)
2) Dokumen Pedoman/Panduan  Penelitian
EOT
],
            ['deskripsi_id' => 25 ,'isi_unsur' => <<<EOT
1) Dokumen sumber pendanaan Penelitian 
2) Sumber Pendanaan Nasional
3) Sumber Pendanaan Internasional
EOT
],
            ['deskripsi_id' => 26 ,'isi_unsur' => <<<EOT
1) Dokumen keterlibatan dosen pada penelitian sesuai bidang ilmu.
2) Dokumen keterlibatan dosen pada penelitian dengan industri.
3) SK keterlibatan mahasiswa dalam penelitian. 
4) Bukti hasil penelitian digunakan untuk mendukung proses belajar mengajar.
EOT
],
            ['deskripsi_id' => 27 ,'isi_unsur' => <<<EOT
1) Dokumen lengkap mulai dari call for proposal hingga laporan akhir. 
2) Monitoring dan Evaluasi kesesuaian penelitian dengan kebijakan dan standar yang ditetapkan 
3) Jumlah Sitasi Per dosen pertahun pada Jurnal Nasional  terindeks Sinta 1 dan Sinta 2 serta Jurnal Intenasional bereputas atu terindeks scopus
EOT
],
            ['deskripsi_id' => 28 ,'isi_unsur' => <<<EOT
1) Dokumen Pengelolaan Pengabdian Kepada Masyarakat yang lengkap (Roadmap, Renstra PKM, RIP PKM) 
2) Dokumen Pedoman/Panduan  Penelitian
EOT
],
            ['deskripsi_id' => 29 ,'isi_unsur' => <<<EOT
1) Dokumen sumber pendanaan Pengabdian Kepada Masyarakat
2) Sumber Pendanaan Nasional
3) Sumber Pendanaan Internasional
EOT
],
            ['deskripsi_id' => 30 ,'isi_unsur' => <<<EOT
1)Dokumen keterlibatan dosen pada PKM sesuai bidang ilmu.
2) Dokumen keterlibatan dosen pada PKM  dengan industri.
3) SK keterlibatan mahasiswa dalam PKM . 
4) Bukti hasil penelitian digunakan untuk mendukung proses belajar mengajar.
EOT
],
            ['deskripsi_id' => 31 ,'isi_unsur' => <<<EOT
1) Dokumen lengkap mulai dari call for proposal hingga laporan akhir. 
2) Monitoring dan Evaluasi kesesuaian PKM  dengan kebijakan dan standar yang ditetapkan
EOT
],
            ['deskripsi_id' => 32 ,'isi_unsur' => <<<EOT
Ketersediaan Bukti:
1)Capaian  dan Pendidikan
a.Capaian pembelajaran lulusan. 
b. IPK lulusan.
c. Prestasi akademik dan non-akademik mahasiswa. 
d. Masa studi, kelulusan tepat waktu, dan keberhasilan studi
e. Pelaksanaan tracer study yang mencakup 5 aspek.
f. Waktu tunggu, kesesuaian bidang kerja, tingkat dan ukuran tempat kerja, serta tingkat kepuasan pengguna lulusan. 
g.Publikasi ilmiah mahasiswa. 
h. Produk dan jasa karya mahasiswa.
i. Luaran penelitian dan PkM mahasiswa
EOT
],
            ['deskripsi_id' => 32 ,'isi_unsur' => '2) Dokumen hasil pengembangan, implementasi, dan evaluasi kurikulum. Untuk pemenuhan capaian Pembelajaran dari internal dan eksternal'],
            ['deskripsi_id' => 32 ,'isi_unsur' => '3) Dokumen rekognisi hasil pendidikan dan pengajaran.'],
            ['deskripsi_id' => 32 ,'isi_unsur' => '4) Dokumen tracer study.'],
            ['deskripsi_id' => 33 ,'isi_unsur' => <<<EOT
5) Dokumen rekognisi hasil dari penelitian dan PkM. 
a) Publikasi Jurnal Terakreditasi Nasional 
a) Publikasi Jurnal Terakreditasi Internasional  
c) Sitasi
EOT
],
            ['deskripsi_id' => 33 ,'isi_unsur' => <<<EOT
6) Dokumen penelitian dan PkM yang menghasilkan output dan outcome.
a )jumlah penelitian bidang infokom?teknik Emba yang mendapat pengakuan HKI (Paten,  Paten Sederhana, Hak Cipta, Desain Produk Industri).
b )jumlah kegiatanPenelitian/ PkM yang relevan dengan bidang infokom yang diadopsi olehmasyarakat.
EOT
],
            ['deskripsi_id' => 33 ,'isi_unsur' => '7) Dokumen pemanfaatan intelektual hasil dari penelitian dan PkM.'],
        ]);
        
    }
}
