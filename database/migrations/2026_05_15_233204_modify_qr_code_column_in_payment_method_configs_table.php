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
        Schema::table('payment_method_configs', function (Blueprint $table) {
            // Drop the old url column and add image column
            if (Schema::hasColumn('payment_method_configs', 'qr_code_url')) {
                $table->dropColumn('qr_code_url');
            }
            $table->string('qr_code_image')->nullable()->after('reference_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_method_configs', function (Blueprint $table) {
            $table->dropColumn('qr_code_image');
            $table->string('qr_code_url')->nullable();
        });
    }
};
