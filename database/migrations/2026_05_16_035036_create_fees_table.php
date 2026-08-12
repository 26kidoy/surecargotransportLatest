<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->integer('amount_per_tray')->default(0);
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        // Using the query builder from the database connection
        $connection = Schema::getConnection();
        $connection->table('fees')->insert([
            'amount_per_tray' => 500,
            'created_at' => $connection->raw('NOW()'),
            'updated_at' => $connection->raw('NOW()'),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};
