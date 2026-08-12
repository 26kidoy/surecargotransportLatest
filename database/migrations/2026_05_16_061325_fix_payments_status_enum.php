<?php

use Illuminate\Database\Migrations\Migration;

use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Step 1: Change to VARCHAR to allow any value
        DB::statement("ALTER TABLE payments MODIFY status VARCHAR(20) NOT NULL DEFAULT 'pending'");

        // Step 2: Convert old status values
        DB::table('payments')->where('status', 'completed')->update(['status' => 'approve']);
        DB::table('payments')->where('status', 'failed')->update(['status' => 'decline']);

        // Step 3: Change back to ENUM with new values
        DB::statement("ALTER TABLE payments MODIFY status ENUM('pending', 'approve', 'decline', 'refunded') NOT NULL DEFAULT 'pending'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE payments MODIFY status VARCHAR(20) NOT NULL DEFAULT 'pending'");
        DB::table('payments')->where('status', 'approve')->update(['status' => 'completed']);
        DB::table('payments')->where('status', 'decline')->update(['status' => 'failed']);
        DB::statement("ALTER TABLE payments MODIFY status ENUM('pending', 'completed', 'failed', 'refunded') NOT NULL DEFAULT 'pending'");
    }
};
