<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentMethodConfig;
use Illuminate\Support\Facades\Schema;

class PaymentMethodConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        Schema::disableForeignKeyConstraints();

        // Clear existing data
        PaymentMethodConfig::truncate();

        // Enable foreign key checks back
        Schema::enableForeignKeyConstraints();

        // Insert fresh data
        $methods = [
            [
                'method_key' => 'gcash',
                'display_name' => 'GCash',
                'account_name' => 'SureCargo Logistics',
                'reference_number' => '0999-123-4567',
                'qr_code_image' => null,
                'instructions' => "1. Open GCash app\n2. Click \"Send Money\"\n3. Enter reference number: 0999-123-4567\n4. Input the exact amount\n5. Send screenshot to our support",
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'method_key' => 'bank_transfer',
                'display_name' => 'Bank Transfer',
                'account_name' => 'SureCargo Logistics Inc.',
                'reference_number' => '1234-5678-9012-3456',
                'qr_code_image' => null,
                'instructions' => "1. Transfer to BDO Account\n2. Account Name: SureCargo Logistics Inc.\n3. Account Number: 1234-5678-9012-3456\n4. Send deposit slip to support",
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'method_key' => 'paymaya',
                'display_name' => 'PayMaya',
                'account_name' => 'SureCargo Logistics',
                'reference_number' => '0912-345-6789',
                'qr_code_image' => null,
                'instructions' => "1. Open PayMaya app\n2. Click \"Send Money\"\n3. Enter PayMaya number: 0912-345-6789\n4. Confirm payment",
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($methods as $method) {
            PaymentMethodConfig::create($method);
        }

        $this->command->info('Payment method configurations seeded successfully!');
        $this->command->info('Created: GCash, Bank Transfer, PayMaya');
    }
}
