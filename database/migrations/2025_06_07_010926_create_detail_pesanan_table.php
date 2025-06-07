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
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->string('id_detail_pesanan', 10)->primary();
            $table->string('id_pesanan', 10);
            $table->string('id_produk', 10);
            $table->integer('jumlah')->notNull();
            $table->decimal('harga_satuan', 10, 2)->notNull();
            $table->timestamp('dibuat_pada')->useCurrent();
            
            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan');
            $table->foreign('id_produk')->references('id_produk')->on('produk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanan');
    }
};
