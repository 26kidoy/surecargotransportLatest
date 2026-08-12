<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('route_trips', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['stopped', 'moving'])->default('stopped');
            $table->integer('current_waypoint_index')->default(0);
            $table->timestamp('started_at')->nullable();
            $table->decimal('current_lat', 10, 7)->nullable();
            $table->decimal('current_lng', 10, 7)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('route_trips');
    }
};
