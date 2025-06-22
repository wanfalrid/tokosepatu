<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Struktur tabel pesanan:\n";
$columns = DB::select('DESCRIBE pesanan');

foreach($columns as $col) {
    echo sprintf("%-20s %-15s %-5s %-10s\n", 
        $col->Field, 
        $col->Type, 
        $col->Null, 
        $col->Default ?: 'NULL'
    );
}
