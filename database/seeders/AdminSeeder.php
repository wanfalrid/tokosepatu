<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin already exists
        $adminExists = DB::table('pengguna')->where('nama_pengguna', 'admin')->exists();
        
        if (!$adminExists) {
            DB::table('pengguna')->insert([
                'id_pengguna' => 'ADM001',
                'nama_pengguna' => 'admin',
                'nama_lengkap' => 'Administrator',
                'email' => 'admin@shoemart.com',
                'kata_sandi' => Hash::make('admin123'),
                'peran' => 'admin',
                'telepon' => '021-1234567',
                'avatar' => null,
                'dibuat_pada' => now(),
            ]);
        }
    }
}
