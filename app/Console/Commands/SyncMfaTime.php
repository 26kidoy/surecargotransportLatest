<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PragmaRX\Google2FA\Google2FA;
use Carbon\Carbon;

class SyncMfaTime extends Command
{
    protected $signature = 'mfa:sync-time';
    protected $description = 'Display MFA time information for debugging';

    public function handle()
    {
        $google2fa = new Google2FA();

        $this->info('=== MFA Time Information ===');
        $this->line('Server Timezone: ' . date_default_timezone_get());
        $this->line('Config Timezone: ' . config('app.timezone'));
        $this->line('Current Server Time: ' . Carbon::now()->toDateTimeString());
        $this->line('Manila Time: ' . Carbon::now('Asia/Manila')->toDateTimeString());
        $this->line('UTC Time: ' . Carbon::now('UTC')->toDateTimeString());
        $this->line('Google2FA Timestamp: ' . $google2fa->getTimestamp());
        $this->line('');
        $this->info('To fix timezone issues:');
        $this->line('1. Set APP_TIMEZONE=Asia/Manila in .env');
        $this->line('2. Run: php artisan config:clear');
        $this->line('3. Restart your server');
    }
}
