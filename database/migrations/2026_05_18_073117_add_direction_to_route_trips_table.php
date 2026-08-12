<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('route_trips', function (Blueprint $table) {
        $table->enum('direction', ['forward', 'backward'])->default('forward')->after('status');
    });
}

public function down()
{
    Schema::table('route_trips', function (Blueprint $table) {
        $table->dropColumn('direction');
    });
}
};
