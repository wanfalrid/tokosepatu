<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tracking_pesanan', function (Blueprint $table) {
            $table->string('id_tracking', 10)->primary();
            $table->string('id_pesanan', 10);
            $table->string('nomor_resi', 50)->notNull();
            $table->string('kurir', 50)->notNull();
            $table->string('status_pengiriman', 100)->notNull();
            $table->datetime('tanggal_update')->notNull();
            $table->text('detail_tracking')->nullable();
            $table->timestamp('dibuat_pada')->useCurrent();
            
            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_pesanan');
    }
};
