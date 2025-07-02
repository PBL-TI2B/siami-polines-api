<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            ['role_id' => 1,
            'unit_kerja_id' => 1,
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123456'), // menggunakan hash
            'nama' => 'admin',
            'nip' => '1234567890', // pastikan unik
            ],
            ['role_id' => 2,
            'unit_kerja_id' => 1,
            'email' => 'auditor@gmail.com',
            'password' => Hash::make('auditor123456'), // menggunakan hash
            'nama' => 'admin',
            'nip' => '1234567891', // pastikan unik
            ],
            ['role_id' => 3,
            'unit_kerja_id' => 1,
            'email' => 'auditee@gmail.com',
            'password' => Hash::make('auditee123456'), // menggunakan hash
            'nama' => 'admin',
            'nip' => '1234567892', // pastikan unik
            ],
            ['role_id' => 4,
            'unit_kerja_id' => 1,
            'email' => 'kepala@gmail.com',
            'password' => Hash::make('kepala123456'), // menggunakan hash
            'nama' => 'admin',
            'nip' => '1234567893', // pastikan unik
            ],
            ['role_id' => 3,
            'unit_kerja_id' => 1,
            'email' => 'auditee1@gmail.com',
            'password' => Hash::make('auditee123457'), // menggunakan hash
            'nama' => 'auditee1',
            'nip' => '1234567895', // pastikan unik
            ],
            ['role_id' => 3,
            'unit_kerja_id' => 1,
            'email' => 'auditee2@gmail.com',
            'password' => Hash::make('auditee123458'), // menggunakan hash
            'nama' => 'auditee2',
            'nip' => '1234567896', // pastikan unik
            ],
            ['role_id' => 2,
            'unit_kerja_id' => 1,
            'email' => 'auditor1@gmail.com',
            'password' => Hash::make('auditor123457'), // menggunakan hash
            'nama' => 'auditor 1',
            'nip' => '1234567897', // pastikan unik
            ],
            ['role_id' => 2,
            'unit_kerja_id' => 1,
            'email' => 'auditor2@gmail.com',
            'password' => Hash::make('auditor123458'), // menggunakan hash
            'nama' => 'auditor 2',
            'nip' => '1234567898', // pastikan unik
            ],
            ['role_id' => 2,
            'unit_kerja_id' => 17,
            'email' => 'kuwatsantoso@gmail.com',
            'password' => Hash::make('kuwat123'), // menggunakan hash
            'nama' => 'KUWAT SANTOSO , S.T., M.Kom.',
            'nip' => '198407192019031008', // pastikan unik
            ],
            ['role_id' => 2,
            'unit_kerja_id' => 21,
            'email' => 'idhawati@gmail.com',
            'password' => Hash::make('idhawati123'), // menggunakan hash
            'nama' => 'IDHAWATI HESTININGSIH, S.KOM., M. KOM.',
            'nip' => '197711192008012013', // pastikan unik
            ],
            ['role_id' => 3,
            'unit_kerja_id' => 17,
            'email' => 'wiktasari@gmail.com',
            'password' => Hash::make('wikta123'), // menggunakan hash
            'nama' => 'WIKTASARI , S.T., M.KOM',
            'nip' => '198703272019032012', // pastikan unik
            ],
            ['role_id' => 3,
            'unit_kerja_id' => 17,
            'email' => 'prayitno@gmail.com',
            'password' => Hash::make('prayitno123'), // menggunakan hash
            'nama' => 'PRAYITNO , S.ST., M.T., Ph.D.',
            'nip' => '198504102014041002', // pastikan unik
            ],
        ]);

    }
}
