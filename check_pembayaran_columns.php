<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->boot();

use Illuminate\Support\Facades\Schema;

echo "Pembayaran table columns:\n";
$columns = Schema::getColumnListing('pembayaran');
foreach ($columns as $column) {
    echo "- " . $column . "\n";
}
