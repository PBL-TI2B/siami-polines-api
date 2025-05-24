<?php

namespace Database\Seeders;

use App\Models\SetInstrumen;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            MenuSeeder::class,
            RoleSeeder::class,
            JenisUnitSeeder::class,
            UnitKerjaSeeder::class,
            PeriodeAuditSeeder::class,
            KriteriaSeeder::class,
            UserSeeder::class,
            // RoleMenuSeeder::class,
            DeskripsiSeeder::class,
            UnsurSeeder::class,
            SetInstrumenSeeder::class,
            RoleMenuAccessSeeder::class,
            RoleSubMenuAccessSeeder::class,
        ]);
    }
}
