<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trucks', function (Blueprint $table) {
            $table->id();
            $table->string('truck_number')->unique();
            $table->string('truck_name');
            $table->string('driver_name');
            $table->string('driver_phone');
            $table->string('truck_model')->nullable();
            $table->string('color')->nullable();
            $table->integer('max_capacity')->default(0);
            $table->integer('low_stock_threshold')->default(0);
            $table->string('image')->nullable();
            $table->enum('status', ['available', 'busy', 'maintenance'])->default('available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trucks');
    }
};
