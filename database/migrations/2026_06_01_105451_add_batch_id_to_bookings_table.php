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
        Schema::table('bookings', function (Blueprint $table) {
            // Add batch_id column after 'status' (or choose another position)
            $table->unsignedBigInteger('batch_id')->nullable()->after('status');

            // Optional: add foreign key constraint if batch_id references another table (e.g., batches.id)
            // $table->foreign('batch_id')->references('id')->on('batches')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Drop foreign key first if you added one
            // $table->dropForeign(['batch_id']);

            $table->dropColumn('batch_id');
        });
    }
};
