<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->timestamps();
        });
        
        // Copy data from dibuat_pada to created_at for existing records
        DB::statement('UPDATE pelanggan SET created_at = dibuat_pada, updated_at = dibuat_pada WHERE dibuat_pada IS NOT NULL');
        
        // For records without dibuat_pada, set timestamps to current time
        DB::statement('UPDATE pelanggan SET created_at = NOW(), updated_at = NOW() WHERE dibuat_pada IS NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
};
