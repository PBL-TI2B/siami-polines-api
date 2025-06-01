<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DeskripsiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('deskripsi')->insert([
            ['kriteria_id' => 1 ,'isi_deskripsi' => 'Kesesuaian Visi, Misi, Tujuan dan Strategi (VMTS) Unit Pengelola Program Studi (UPPS) terhadap VMTS Perguruan tinggi (PT) dan Visi keilmuan Program Studi (PS) yang dikelolanya.'],
            ['kriteria_id' => 1 ,'isi_deskripsi' => 'Mekanisme dan keterlibatan pemangku kepentingan dalam penyusunan VMTS UPPS.'],
            ['kriteria_id' => 1 ,'isi_deskripsi' => 'Strategi pencapaian tujuan disusun berdasarkan analisis yang sistematis, serta pada pelaksanaannya dilakukan pemantauan dan evaluasi yang ditindaklanjuti.'],
            ['kriteria_id' => 2 ,'isi_deskripsi' => 'Unit Pengelola Program Studi mendeskripsikan proses, struktur dan tradisi dalam menjalankan tugas dan menggunakan wewenangnya untuk mengemban misi,mewujudkan visi, dan mencapai tujuan, serta sasaran strategisnya yang didukung perilaku etis dan berintegritas para pengelola, tenaga kependidikan, mahasiswa, dan mitra Unit Pengelola Program Studi.'],
            ['kriteria_id' => 2 ,'isi_deskripsi' => 'Unit Pengelola Program Studi mendeskripsikan peran, tanggung jawab, wewenang dan proses pengambilan keputusan untuk pencapaian efektivitas organisasi berdasarkan visi, misi, tujuan, dan strategi serta  menggunakan lima pilar sistem tata pamong, yangmencakup:  kredibel, transparan, akuntabel, bertanggung jawab, dan adil.'],
            ['kriteria_id' => 2 ,'isi_deskripsi' => 'Unit Pengelola Program Studi mendeskripsikan perencanaan, pengorganisasian, pengarahan, dan pengendalian sumber daya agar program studi dapat menjalankan tugas  dan kewajibannya secara efektif dan efisien serta akuntabel, bertanggung jawab, transparan, adil, dan terhindar dari konflik kepentingan yang ditunjukkan dengan hasil, evaluasi kepuasan para pemangku kepentingan terhadap keterlaksanaan dan efektivitas  tata kelola.'],
            ['kriteria_id' => 2 ,'isi_deskripsi' => 'Unit Pengelola Program Studi mendeskripsikan sistem manajemen mutu internal yang diimplementasikan secara konsisten, efektif, dan efisien serta dilaporkan secara berkala untuk tindak lanjut peningkatan mutu pendidikan tinggi.'],
            ['kriteria_id' => 2 ,'isi_deskripsi' => 'Unit Pengelola Program Studi menjelaskan kegiatan dengan para mitranya dan hasil dari kegiatan tersebut.  2) Unit Pengelola Program Studi menjelaskan keselarasan dan konsistensi antara kerja sama, visi, misi, tujuan, dan aspirasi para pemangku kepentingan dengan memperhatikan isu ekonomi dan bisnis yang berkembang untuk memberi dampak positif kepada para pemangku kepentingan dan masyarakat luas.'],
            ['kriteria_id' => 2 ,'isi_deskripsi' => '3) Unit Pengelola Program Studi menjelaskan cakupan kerja sama bidang Ilmu EMBA dan dampaknya. Kegiatan kerja sama program studi dapat mencakup bidang pendidikan, Kriteria dan Prosedur – Instrumen Akreditasi Program Studi (LAMEMBA) penelitian, dan/atau pengabdian kepada masyarakat dengan memperhatikan isu ekonomi dan bisnis yang berkembang di tingkat lokal, nasional, dan/atau internasional.  4) Unit Pengelola Program Studi melakukan evaluasi kerjasama secara berkala dan tindak lanjut dengan mempertimbangkan dampak internal dan eksternal Kerjasama.'],
            ['kriteria_id' => 3 ,'isi_deskripsi' => 'Penilaian kriteria ini difokuskan pada: 1) Konsistensi pelaksanaan dan keefektifan sistem penerimaan mahasiswa baru yang adil dan objektif. 2) Keseimbangan rasio mahasiswa dengan dosen dan tenaga kependidikan yang menunjang pelaksanaan pembelajaran yang efektif dan efisien. 3) Program, keterlibatan dan prestasi mahasiswa dalam pembinaan minat, bakat, dan keprofesian. 4) Efektifitas sistem layanan bagi mahasiswa dalam menunjang proses pembelajaran yang efektif dan efisien.'],
            ['kriteria_id' => 4 ,'isi_deskripsi' => 'Ketersediaan Profil Dosen Tetap  pragram Studi  (kecukupan jumlah, jabfung, kualifikasi, keahlian, beban kerja EWMP, keanggotaan dalam organisasi, sertifikasi profesi, dan sertifikat kompetensi).'],
            ['kriteria_id' => 4 ,'isi_deskripsi' => 'Keterlaksanaan atas Kebijakan, standar SNDikti dan SPT PT  berkaitan dengan Sumber daya Manusia.'],
            ['kriteria_id' => 4 ,'isi_deskripsi' => 'Pengembangan Dosen dan tenaga kependidikan dengan efektif.'],
            ['kriteria_id' => 4 ,'isi_deskripsi' => 'Keterlaksanaan evaluasi secara berkala mengenai kebijakan dan ketercapaian standar (IKU dan IKT) sehingga menemu-kenali praktik baik, praktik buruk dan praktik yang baru yang berkaitan dengan sumber daya manusia.'],
            ['kriteria_id' => 5 ,'isi_deskripsi' => 'Standar pembiayaan difokuskan pada kecukupan, keefektifan, efisiensi, dan akuntabilitas, serta keberlanjutan pembiayaan untuk menunjang penyelenggaraan pendidikan, penelitian, dan pengabdian kepada masyarakat.'],
            ['kriteria_id' => 5 ,'isi_deskripsi' => 'Penilaian sarana dan prasarana difokuskan pada pemenuhan ketersediaan (availability) sarana prasarana, akses civitasakademika terhadap sarana prasarana (accessibility), kegunaan atau pemanfaatan (utility) sarana prasarana oleh sivitas akademika, serta keamanan, keselamatan, kesehatan dan lingkungan dalam menunjang pelaksanaan tridarma perguruan tinggi.'],
            ['kriteria_id' => 5 ,'isi_deskripsi' => 'Keterlaksanaan evaluasi mengenai kebijakan dan ketercapaian standar (IKU dan IKT) sehingga menemu-kenali praktik baik, praktik buruk dan praktik yang baru yang berkaitan dengan keuangan, sarana, dan prasarana, termasuk evaluasi kepuasan dosen, tenaga kependidikan dan mahasiswa terhadap ketersediaan dan keteraksesan sarana prasarana.'],
            ['kriteria_id' => 6 ,'isi_deskripsi' => 'A. Ketersediaan kebijakan, standar, IKU, dan IKT yang berkaitan dengan pendidikan/pembelajaran yang mencakup: A. Profil Lulusan, Capaian Pembelajaran Lulusan (CPL) sesauai dengan Profil Lulusan dan jenjang KKNI/SKKNI.'],
            ['kriteria_id' => 6 ,'isi_deskripsi' => 'Kurikulum Program studi yang mutakhir dan relevan dengan kebutuhan  keimuan Teknokmemilii perpektif global, sesuai dengan VMTS dan Capaian pembelajaran.'],
            ['kriteria_id' => 6 ,'isi_deskripsi' => 'C. Ketepatan struktur kurikulum dalam pembentukan capaian pembelajaran, digambarkan dalam peta kompetensi / Peta jalan CPL.'],
            ['kriteria_id' => 6 ,'isi_deskripsi' => 'Struktur Kurikulum berbasis KKNI/OBE/SKKNI sesuai dengan Profil Lulusan, Capaian Pembelajaran Lulusan (CPL), Capaian Pembelajaran Mata Kuliah (CPMK), RPS, Struktur Mata Kuliah dan Asesmen Penilaian yang sangat lengkap.'],
            ['kriteria_id' => 6 ,'isi_deskripsi' => 'Kebijakan terkait penciptaan suasana akademik, melalui kegiatan ilmiah yang terjadwal, disertai bukti yang sahih dan sangat lengkap.'],
            ['kriteria_id' => 6 ,'isi_deskripsi' => 'Mekanisme integrasi topik penelitian dan kegiatan PkM ke dalam proses pembelajaran.'],
            ['kriteria_id' => 7 ,'isi_deskripsi' => 'Unit Pengelola Program Studi mendeskripsikan pedoman pelaksanaan dan roadmap  penelitian yang sesuai dengan visi dan misi serta isu-isu  yang berkembang baik di tingkat lokal, nasional, maupun internasional.  (Sesuai bidangkeilmuan program studi yang diakreditasi.)'],
            ['kriteria_id' => 7 ,'isi_deskripsi' => 'Unit Pengelola Program Studi dan program studi mendeskripsikan sumber pendanaan yang bersal dariinternal, pemerintah, industri atau  Lembaga   Lain dengan daya saing nasional/Internasional.'],
            ['kriteria_id' => 7 ,'isi_deskripsi' => 'Unit Pengelola Program Studi mendeskripsikan penelitian dosen dan/atau dosen dengan mahasiswa yang sesuai dengan roadmap penelitian dan/atau bermitra dengan pihak eksternal pada tahun berjalan serta didesiminasikan dalam publikasi dan/atau pertemuan ilmiah tingkat lokal, nasional, atau internasional dan mendukung VTMS.'],
            ['kriteria_id' => 7 ,'isi_deskripsi' => 'Pelaksanaan monitoring kesesuaian penelitian DTPR dengan Rencana Induk Penelitian, dan penggunaan hasil evaluasi untuk perbaikan relevansi penelitian dan pengembangan keilmuan program studi.'],
            ['kriteria_id' => 8 ,'isi_deskripsi' => 'Unit Pengelola Program Studi memberikan arah pengembangan pengabdian kepada masyarakat, komitmen untuk mengembangkan pengabdian kepada masyarakat yang bermutu dan unggul, memiliki dampak terhadap  pengembangan ekonomi lokal, nasional, dan global, sesuai dengan visi, misi, dan roadmap pengabdian kepada masyarakat.'],
            ['kriteria_id' => 8 ,'isi_deskripsi' => 'Unit Pengelola Program Studi dan program studi mendeskripsikan sumber pendanaan   pengabdian kepada masyarakat sesuai dengan visi dan misi serta isu-isu ekonomi dan bisnis yang berkembang baik di tingkat lokal, nasional, maupun internasional.'],
            ['kriteria_id' => 8 ,'isi_deskripsi' => 'Pengabdian kepada masyarakat dosen dan/atau dosen dengan mahasiswa yang sesuai dengan roadmap PKM dan/atau bermitra dengan pihak eksternal pada tahun berjalan  didesiminasikan dalam publikasi dan/atau pertemuan ilmiah tingkat lokal, nasional, ainternasional dan mendukung visi, misi, tujuan, dan strategi.'],
            ['kriteria_id' => 8 ,'isi_deskripsi' => 'Unit Pengelola Program Studi dan program studi mendeskripsikan kontribusi hasil pengabdian kepada masyarakat pada pengembangan pengajaran, ilmu pengetahuan, dan praktik di bidang sesuai dengan keilmuan.'],
            ['kriteria_id' => 9 ,'isi_deskripsi' => 'Penilaian difokuskan pada pencapaian kualifikasi dan kompetensi lulusan berupa gambaran yang jelas tentang profil dan capaian pembelajaran lulusan dari program studi, penelusuran lulusan, umpan balik dari pengguna lulusan, dan persepsi publik terhadap lulusan sesuai dengan capaian pembelajaran lulusan/kompetensi yang ditetapkan oleh program studi dan perguruan tinggi dengan mengacu pada KKNI, jumlah dan keungggulan publikasi ilmiah.'],
            ['kriteria_id' => 9 ,'isi_deskripsi' => 'Jumlah dan keungggulan publikasi ilmiah, jumlah sitasi, jumlah hak kekayaan intelektual, dan kemanfaatan/dampak hasil penelitian terhadap pewujudan visi dan penyelenggaraan misi, serta kontribusi pengabdian kepadamasyarakat pada pengembangan dan pemberdayaan sosial, ekonomi, dan kesejahteraan masyarakat.'],
        ]);
        
    }
}
