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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->string('id_pembayaran', 10)->primary();
            $table->string('id_pesanan', 10)->unique();
            $table->string('id_pengguna', 10);
            $table->decimal('jumlah', 10, 2)->notNull();
            $table->datetime('tanggal_pembayaran')->notNull();
            $table->enum('status_pembayaran', ['menunggu', 'dibayar', 'dibatalkan'])->default('menunggu');
            $table->timestamp('dibuat_pada')->useCurrent();
            
            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan');
            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
