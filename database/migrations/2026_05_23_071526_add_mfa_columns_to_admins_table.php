<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->string('google2fa_secret')->nullable()->after('password');
            $table->json('recovery_codes')->nullable()->after('google2fa_secret');
            $table->boolean('mfa_enabled')->default(false)->after('recovery_codes');
        });
    }

    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn(['google2fa_secret', 'recovery_codes', 'mfa_enabled']);
        });
    }
};
