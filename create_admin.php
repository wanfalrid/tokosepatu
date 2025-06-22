<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// Initialize Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    // Check if admin already exists
    $existingAdmin = DB::table('pengguna')->where('peran', 'admin')->first();
    
    if ($existingAdmin) {
        echo "Admin sudah ada: " . $existingAdmin->nama_lengkap . "\n";
    } else {
        // Create admin
        $result = DB::table('pengguna')->insert([
            'id_pengguna' => 'ADM001',
            'nama_lengkap' => 'Super Admin',
            'email' => 'admin@shoemart.com',
            'kata_sandi' => Hash::make('admin123'),
            'peran' => 'admin',
            'telepon' => '08123456789',
            'dibuat_pada' => now(),
        ]);
        
        if ($result) {
            echo "Admin berhasil dibuat!\n";
            echo "Email: admin@shoemart.com\n";
            echo "Password: admin123\n";
        } else {
            echo "Gagal membuat admin!\n";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
