<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::create('batches', function (Blueprint $table) {
        $table->id();
        $table->string('batch_number')->unique();
        $table->timestamp('created_at')->useCurrent();
        $table->boolean('is_active')->default(false);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
