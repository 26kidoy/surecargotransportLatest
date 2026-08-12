<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('fee_per_tray', 10, 2)->nullable()->after('quantity');
            $table->decimal('total_amount', 10, 2)->nullable()->after('fee_per_tray');
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['fee_per_tray', 'total_amount']);
        });
    }
};
