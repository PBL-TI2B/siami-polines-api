<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\SubMenu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // Hapus data menggunakan delete() untuk menghormati foreign key constraints
        Menu::query()->delete(); // Ini akan memicu ON DELETE CASCADE di role_menu_access
        SubMenu::query()->delete();

        // ROLE ADMIN
        $dashboard = Menu::create([
            'nama_menu' => 'Dashboard',
            'route' => 'dashboard.index',
            'icon' => 'heroicon-o-home',
        ]);

        $periodeAudit = Menu::create([
            'nama_menu' => 'Periode Audit',
            'route' => 'periode-audit.index',
            'icon' => 'heroicon-o-calendar-days',
        ]);

        $audit = Menu::create([
            'nama_menu' => 'Audit',
            'route' => 'audit.index',
            'icon' => 'heroicon-o-clock',
        ]);

        $plotingAMI = Menu::create([
            'nama_menu' => 'Ploting AMI',
            'route' => 'ploting-ami.index',
            'icon' => 'heroicon-o-user-plus',
        ]);

        $daftarTilik = Menu::create([
            'nama_menu' => 'Daftar Tilik',
            'route' => 'daftar-tilik.index',
            'icon' => 'heroicon-o-check-circle',
        ]);

        $dataUnit = Menu::create([
            'nama_menu' => 'Data Unit',
            'route' => 'unit-kerja.index',
            'icon' => 'heroicon-o-building-office',
        ]);

        $dataInstrumen = Menu::create([
            'nama_menu' => 'Data Instrumen',
            'route' => 'data-instrumen.index',
            'icon' => 'heroicon-o-clipboard-document',
        ]);

        $dataUser = Menu::create([
            'nama_menu' => 'Data User',
            'route' => 'data-user.index',
            'icon' => 'heroicon-o-users',
        ]);

        $assesmenLapangan = Menu::create([
            'nama_menu' => 'Assesmen Lapangan',
            'route' => 'assesmen-lapangan.index',
            'icon' => 'heroicon-o-map',
        ]);

        $pengisianInstrumen = Menu::create([
            'nama_menu' => 'Pengisian Instrumen',
            'route' => 'pengisian-instrumen.index',
            'icon' => 'heroicon-o-document-text',
        ]);

        $tindakLanjutPerbaikan = Menu::create([
            'nama_menu' => 'Tindak Lanjut Perbaikan',
            'route' => 'tindak-lanjut-perbaikan.index',
            'icon' => 'heroicon-o-check-circle',
        ]);

        $riwayatAudit = Menu::create([
            'nama_menu' => 'Riwayat Audit',
            'route' => 'riwayat-audit.index',
            'icon' => 'heroicon-o-clock',
        ]);

        $rapatTinjauanManajemen = Menu::create([
            'nama_menu' => 'Rapat Tinjauan Manajemen',
            'route' => 'rapat-tinjauan-manajemen.index',
            'icon' => 'heroicon-o-users',
        ]);

        $reviewTemuanAudit = Menu::create([
            'nama_menu' => 'Review Temuan Audit',
            'route' => 'review-temuan-audit.index',
            'icon' => 'heroicon-o-document-text',
        ]);

        $dokumenAudit = Menu::create([
            'nama_menu' => 'Dokumen Audit',
            'route' => 'dokumen-audit.index',
            'icon' => 'heroicon-o-document-text',
        ]);

         $ptpp = Menu::create([
            'nama_menu' => 'PTPP',
            'route' => 'ptpp.index',
            'icon' => 'heroicon-o-document-check',
        ]);

        $laporan = Menu::create([
            'nama_menu' => 'Laporan',
            'route' => 'laporan.index',
            'icon' => 'heroicon-o-document-text',
        ]);


        // Submenu untuk Data Unit
        SubMenu::create([
            'nama_sub_menu' => 'Daftar UPT',
            'menu_id' => $dataUnit->menu_id,
            'route' => 'unit-kerja.index',
            'icon' => 'heroicon-o-building-office',
            'route_params' => json_encode(['type' => 'upt']),
        ]);

        SubMenu::create([
            'nama_sub_menu' => 'Daftar Prodi',
            'menu_id' => $dataUnit->menu_id,
            'route' => 'unit-kerja.index',
            'icon' => 'heroicon-o-academic-cap',
            'route_params' => json_encode(['type' => 'prodi']),
        ]);

        SubMenu::create([
            'nama_sub_menu' => 'Daftar Jurusan',
            'menu_id' => $dataUnit->menu_id,
            'route' => 'unit-kerja.index',
            'icon' => 'heroicon-o-book-open',
            'route_params' => json_encode(['type' => 'jurusan']),
        ]);

        // Submenu untuk Data Instrumen
        SubMenu::create([
            'nama_sub_menu' => 'Instrumen UPT',
            'menu_id' => $dataInstrumen->menu_id,
            'route' => 'data-instrumen.index',
            'icon' => 'heroicon-o-clipboard-document',
            'route_params' => json_encode(['type' => 'upt']),
        ]);

        SubMenu::create([
            'nama_sub_menu' => 'Instrumen Prodi',
            'menu_id' => $dataInstrumen->menu_id,
            'route' => 'data-instrumen.instrumenprodi',
            'icon' => 'heroicon-o-clipboard-document',
            'route_params' => json_encode(['type' => 'prodi']),
        ]);

        SubMenu::create([
            'nama_sub_menu' => 'Instrumen Jurusan',
            'menu_id' => $dataInstrumen->menu_id,
            'route' => 'data-instrumen.instrumenjurusan',
            'icon' => 'heroicon-o-clipboard-document',
            'route_params' => json_encode(['type' => 'jurusan']),
        ]);
    }
}
