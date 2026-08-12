<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // If your status column is an ENUM, we need to alter the ENUM values.
        // If it's a plain string, we just ensure it's large enough.
        // This safe approach works for both cases.
        Schema::table('payments', function (Blueprint $table) {
            // Change column to string if it was ENUM (MySQL specific)
            // This avoids ENUM limitations – recommended for Laravel.
            $table->string('status')->default('pending')->change();
        });

        // For MySQL ENUM, you might need raw DB statement, but changing to string is simplest.
        // If you prefer to keep ENUM, uncomment the following (adjust table/column names):
        // DB::statement("ALTER TABLE payments MODIFY COLUMN status ENUM('pending','approve','decline','refunded','cod') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        // Revert to original allowed values (without 'cod')
        Schema::table('payments', function (Blueprint $table) {
            $table->string('status')->default('pending')->change();
        });
        // Or for ENUM revert:
        // DB::statement("ALTER TABLE payments MODIFY COLUMN status ENUM('pending','approve','decline','refunded') NOT NULL DEFAULT 'pending'");
    }
};
