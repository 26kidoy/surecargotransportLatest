<?php
// database/seeders/SecretCodeSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;

class SecretCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if settings table exists
        if (!Schema::hasTable('settings')) {
            $this->command->error('❌ Settings table not found. Please run migrations first.');
            return;
        }

        // Check if secret_code already exists
        $existing = Setting::where('key', 'secret_code')->first();

        if ($existing) {
            $this->command->info('ℹ️  Secret code already exists: ' . $existing->value);
            $this->command->warn('⚠️  Skipping to avoid overwriting existing value.');
            return;
        }

        // Set default secret code
        Setting::setValue(
            'secret_code',
            '111111111',
            'string',
            'security',
            'Default secret code for old customers to access the platform'
        );

        $this->command->info('✅ Secret code seeded successfully!');
        $this->command->info('🔐 Code: 111111111');
        $this->command->info('📝 You can change this later from the admin panel.');
    }
}
