<?php
// database/migrations/2026_01_15_000001_create_user_requests_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_requests', function (Blueprint $table) {
            $table->id();
            $table->string('know_site')->nullable();
            $table->text('message')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();

            // Add indexes for better performance
            $table->index('status');
            $table->index('ip_address');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_requests');
    }
};
