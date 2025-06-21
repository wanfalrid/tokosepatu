<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */    public function up(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->string('metode_pengiriman')->nullable()->after('status_pesanan');
            $table->decimal('ongkos_kirim', 10, 2)->default(0)->after('metode_pengiriman');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropColumn(['metode_pengiriman', 'ongkos_kirim']);
        });
    }
};
