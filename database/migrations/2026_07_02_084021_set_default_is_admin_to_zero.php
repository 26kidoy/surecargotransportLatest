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
        // 1️⃣ Change the default value for ALL future records
        DB::statement('ALTER TABLE users MODIFY is_admin TINYINT(1) NOT NULL DEFAULT 0');

        // 2️⃣ Update existing users.
        //    Choose the option that fits your needs:

        // OPTION A: Set is_admin = 0 for EVERY existing user (safe if you only have one admin or want all to be 0)
        // DB::table('users')->update(['is_admin' => 0]);

        // OPTION B (RECOMMENDED): Keep real admins safe.
        // Only set is_admin = 0 for users whose role is NOT 'admin'
        DB::table('users')->where('role', '!=', 'admin')->update(['is_admin' => 0]);

        // OPTION C: Update only a specific user by ID (if you know which one)
        // DB::table('users')->where('id', 1)->update(['is_admin' => 0]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert the default back to 1 (or whatever it was originally)
        DB::statement('ALTER TABLE users MODIFY is_admin TINYINT(1) NOT NULL DEFAULT 1');

        // Optionally, revert the data (e.g., set admins back to 1 if you want)
        // DB::table('users')->where('role', 'admin')->update(['is_admin' => 1]);
    }
};
