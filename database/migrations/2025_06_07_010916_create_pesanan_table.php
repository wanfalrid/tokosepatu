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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->string('id_pesanan', 10)->primary();
            $table->string('id_pelanggan', 10);
            $table->string('id_pengguna', 10);
            $table->decimal('total_harga', 10, 2)->notNull();
            $table->enum('status_pesanan', ['menunggu', 'diproses', 'dikirim', 'selesai'])->default('menunggu');
            $table->date('tanggal_pesanan')->notNull();
            $table->datetime('estimasi_selesai')->nullable();
            $table->string('nomor_resi', 50)->nullable();
            $table->timestamp('dibuat_pada')->useCurrent();
            
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggan');
            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
