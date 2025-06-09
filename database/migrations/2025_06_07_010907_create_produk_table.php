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
        Schema::create('produk', function (Blueprint $table) {
            $table->string('id_produk', 10)->primary();
            $table->string('nama_produk', 50)->notNull()->unique();
            $table->decimal('harga', 10, 2)->notNull();
            $table->integer('stok')->notNull()->default(0);
            $table->string('gambar')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('merek', 50)->nullable();
            $table->string('ukuran', 20)->nullable();
            $table->string('warna', 30)->nullable();
            $table->timestamp('dibuat_pada')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};