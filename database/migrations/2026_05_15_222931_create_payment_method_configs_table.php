<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_method_configs', function (Blueprint $table) {
            $table->id();
            $table->string('method_key')->unique(); // gcash, bank_transfer, paymaya
            $table->string('display_name');
            $table->string('account_name')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('qr_code_url')->nullable();
            $table->text('instructions')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_method_configs');
    }
};
