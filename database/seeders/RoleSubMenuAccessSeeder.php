<?php

namespace Database\Seeders;

use App\Models\SubMenu;
use App\Models\RoleSubMenuAccess;
use Illuminate\Database\Seeder;

class RoleSubMenuAccessSeeder extends Seeder
{
    public function run()
    {
        RoleSubMenuAccess::query()->delete();

        $subMenus = SubMenu::all()->keyBy('nama_sub_menu');

        $access = [
            // Admin (role_id: 1) - Akses semua sub-menu
            ['role_id' => 1, 'sub_menu_id' => $subMenus['Daftar UPT']->sub_menu_id],
            ['role_id' => 1, 'sub_menu_id' => $subMenus['Daftar Prodi']->sub_menu_id],
            ['role_id' => 1, 'sub_menu_id' => $subMenus['Daftar Jurusan']->sub_menu_id],
            ['role_id' => 1, 'sub_menu_id' => $subMenus['Instrumen UPT']->sub_menu_id],
            ['role_id' => 1, 'sub_menu_id' => $subMenus['Instrumen Prodi']->sub_menu_id],
            ['role_id' => 1, 'sub_menu_id' => $subMenus['Instrumen Jurusan']->sub_menu_id],

            // Auditor (role_id: 2) - Akses sub-menu Data Instrumen
            ['role_id' => 2, 'sub_menu_id' => $subMenus['Instrumen UPT']->sub_menu_id],
            ['role_id' => 2, 'sub_menu_id' => $subMenus['Instrumen Prodi']->sub_menu_id],
            ['role_id' => 2, 'sub_menu_id' => $subMenus['Instrumen Jurusan']->sub_menu_id],

            // Auditee (role_id: 3) - Akses sub-menu Data Instrumen
            ['role_id' => 3, 'sub_menu_id' => $subMenus['Instrumen UPT']->sub_menu_id],
            ['role_id' => 3, 'sub_menu_id' => $subMenus['Instrumen Prodi']->sub_menu_id],
            ['role_id' => 3, 'sub_menu_id' => $subMenus['Instrumen Jurusan']->sub_menu_id],

            // Kepala PMPP (role_id: 4) - Akses semua sub-menu
            ['role_id' => 4, 'sub_menu_id' => $subMenus['Daftar UPT']->sub_menu_id],
            ['role_id' => 4, 'sub_menu_id' => $subMenus['Daftar Prodi']->sub_menu_id],
            ['role_id' => 4, 'sub_menu_id' => $subMenus['Daftar Jurusan']->sub_menu_id],
            ['role_id' => 4, 'sub_menu_id' => $subMenus['Instrumen UPT']->sub_menu_id],
            ['role_id' => 4, 'sub_menu_id' => $subMenus['Instrumen Prodi']->sub_menu_id],
            ['role_id' => 4, 'sub_menu_id' => $subMenus['Instrumen Jurusan']->sub_menu_id],

            // Admin UPT (role_id: 5) - Hanya akses Daftar UPT dan Instrumen UPT
            ['role_id' => 5, 'sub_menu_id' => $subMenus['Daftar UPT']->sub_menu_id],
            ['role_id' => 5, 'sub_menu_id' => $subMenus['Instrumen UPT']->sub_menu_id],
        ];

        RoleSubMenuAccess::insert($access);
    }
}
