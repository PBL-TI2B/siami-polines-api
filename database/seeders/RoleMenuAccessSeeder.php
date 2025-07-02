<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\RoleMenuAccess;
use Illuminate\Database\Seeder;

class RoleMenuAccessSeeder extends Seeder
{
    public function run()
    {
        RoleMenuAccess::query()->delete();

        $menus = Menu::all()->keyBy('nama_menu');

        $access = [
            // Admin (role_id: 1) - Akses semua menu
            ['role_id' => 1, 'menu_id' => $menus['Dashboard']->menu_id],
            ['role_id' => 1, 'menu_id' => $menus['Periode Audit']->menu_id],
            ['role_id' => 1, 'menu_id' => $menus['Ploting AMI']->menu_id],
            ['role_id' => 1, 'menu_id' => $menus['Daftar Tilik']->menu_id],
            ['role_id' => 1, 'menu_id' => $menus['Data Unit']->menu_id],
            ['role_id' => 1, 'menu_id' => $menus['Data Instrumen']->menu_id],
            ['role_id' => 1, 'menu_id' => $menus['Data User']->menu_id],

            // Auditor (role_id: 2) - Akses menu audit
            ['role_id' => 2, 'menu_id' => $menus['Dashboard']->menu_id],
            ['role_id' => 2, 'menu_id' => $menus['Audit']->menu_id],
            ['role_id' => 2, 'menu_id' => $menus['Riwayat Audit']->menu_id],


            // Auditee (role_id: 3) - Akses menu audit
            ['role_id' => 3, 'menu_id' => $menus['Dashboard']->menu_id],
            ['role_id' => 3, 'menu_id' => $menus['Audit']->menu_id],
            ['role_id' => 3, 'menu_id' => $menus['Riwayat Audit']->menu_id],

            // Kepala PMPP (role_id: 4) - Akses menu audit
            ['role_id' => 4, 'menu_id' => $menus['Dashboard']->menu_id],
            ['role_id' => 4, 'menu_id' => $menus['Ploting AMI']->menu_id],
            ['role_id' => 4, 'menu_id' => $menus['Daftar Tilik']->menu_id],
            ['role_id' => 4, 'menu_id' => $menus['Data Instrumen']->menu_id],
        ];

        RoleMenuAccess::insert($access);
    }
}
