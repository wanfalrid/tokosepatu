<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Pesanan tersedia:\n";
$pesanan = App\Models\Pesanan::select('id_pesanan', 'status_pesanan')->take(3)->get();

foreach ($pesanan as $p) {
    echo $p->id_pesanan . ' - ' . $p->status_pesanan . "\n";
}
