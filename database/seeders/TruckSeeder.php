<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TruckSeeder extends Seeder
{
    public function run()
    {
        DB::table('trucks')->insert([
            [
                'truck_number' => 'TRUCK-001',
                'truck_name' => 'Volvo FH16',
                'driver_name' => 'John Santos',
                'driver_phone' => '+63 912 345 6789',
                'truck_model' => 'Volvo FH16',
                'color' => 'White',
                'max_capacity' => 12000,
                'low_stock_threshold' => 500,
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'truck_number' => 'TRUCK-002',
                'truck_name' => 'Scania R500',
                'driver_name' => 'Mike Reyes',
                'driver_phone' => '+63 923 456 7890',
                'truck_model' => 'Scania R500',
                'color' => 'Red',
                'max_capacity' => 12000,
                'low_stock_threshold' => 500,
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
