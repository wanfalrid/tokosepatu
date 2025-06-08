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
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->string('id_pelanggan', 10)->primary();
            $table->string('nama', 100)->notNull();
            $table->string('email', 255)->unique()->notNull();
            $table->string('telepon', 15)->notNull();
            $table->text('alamat')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('kata_sandi', 255)->notNull();
            $table->enum('status_akun', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamp('dibuat_pada')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};
