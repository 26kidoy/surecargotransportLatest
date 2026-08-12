<?php
// database/seeders/AdminUserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Set default secret code ONLY if it doesn't exist
        $existing = Setting::where('key', 'secret_code')->first();

        if (!$existing) {
            Setting::setValue(
                'secret_code',
                '111111111',
                'string',
                'security',
                'Default secret code for old customers to access the platform'
            );
            $this->command->info('🔐 Default secret code set to: 111111111');
        } else {
            $this->command->info('ℹ️  Secret code already exists: ' . $existing->value);
            $this->command->warn('⚠️  Skipping to avoid overwriting existing value.');
        }

        // 2. Create sample user requests for testing (optional)
        $this->createSampleRequests();
    }

    /**
     * Create sample user requests for testing
     */
    private function createSampleRequests(): void
    {
        // Check if user_requests table exists and has records
        if (!Schema::hasTable('user_requests')) {
            $this->command->warn('⚠️  user_requests table not found. Skipping sample requests.');
            return;
        }

        if (DB::table('user_requests')->count() > 0) {
            $this->command->info('ℹ️  Sample requests already exist. Skipping.');
            return;
        }

        $requests = [
            [
                'know_site' => 'social',
                'message' => 'I found SureCargo on LinkedIn and I\'m very interested in your logistics services.',
                'ip_address' => '192.168.1.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'status' => 'pending',
                'created_at' => now()->subHours(2),
                'updated_at' => now()->subHours(2),
            ],
            [
                'know_site' => 'friend',
                'message' => 'My business partner recommended SureCargo. We need reliable cargo shipping.',
                'ip_address' => '192.168.1.2',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
                'status' => 'pending',
                'created_at' => now()->subDay(),
                'updated_at' => now()->subDay(),
            ],
            [
                'know_site' => 'search',
                'message' => 'Found you through Google search. Looking for real-time tracking solutions.',
                'ip_address' => '192.168.1.3',
                'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X) AppleWebKit/605.1.15',
                'status' => 'approved',
                'approved_at' => now()->subHours(5),
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subHours(5),
            ],
            [
                'know_site' => 'ad',
                'message' => 'Saw your ad on Facebook. Need to ship cargo internationally.',
                'ip_address' => '192.168.1.4',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:91.0) Gecko/20100101 Firefox/91.0',
                'status' => 'rejected',
                'rejected_at' => now()->subHours(3),
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subHours(3),
            ],
        ];

        foreach ($requests as $requestData) {
            DB::table('user_requests')->insert($requestData);
        }

        $this->command->info('📋 Sample user requests created for testing.');
        $this->command->info('   - 2 pending');
        $this->command->info('   - 1 approved');
        $this->command->info('   - 1 rejected');
    }
}
