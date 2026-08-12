<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        Setting::setValue('max_egg_trays', 12000, 'integer', 'inventory', 'Maximum capacity for egg trays');
        Setting::setValue('low_stock_threshold', 500, 'integer', 'inventory', 'Alert when stock falls below this number');
    }
}
