<?php
// database/migrations/2026_08_09_000000_add_default_secret_code.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Check if secret_code exists in settings
        $exists = DB::table('settings')->where('key', 'secret_code')->exists();
        
        if (!$exists) {
            DB::table('settings')->insert([
                'key' => 'secret_code',
                'value' => '111111111',
                'type' => 'string',
                'group' => 'security',
                'description' => 'Secret code for old customers to access the platform',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    public function down()
    {
        DB::table('settings')->where('key', 'secret_code')->delete();
    }
};