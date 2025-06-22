<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "CREATE TABLE statement for pesanan:\n";
$result = DB::select('SHOW CREATE TABLE pesanan');
echo $result[0]->{'Create Table'};
echo "\n";
