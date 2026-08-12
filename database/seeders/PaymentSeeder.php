<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\User;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if ($user) {
            Payment::create([
                'user_id' => $user->id,
                'booking_id' => null,
                'payment_reference' => 'PAY-' . strtoupper(uniqid()),
                'transaction_id' => 'TXN-' . rand(100000, 999999),
                'amount' => 150.00,
                'payment_method' => 'gcash',
                'status' => 'completed',
                'payment_date' => now(),
                'notes' => 'Test payment',
            ]);

            Payment::create([
                'user_id' => $user->id,
                'booking_id' => null,
                'payment_reference' => 'PAY-' . strtoupper(uniqid()),
                'transaction_id' => 'TXN-' . rand(100000, 999999),
                'amount' => 250.00,
                'payment_method' => 'bank_transfer',
                'status' => 'pending',
                'payment_date' => now(),
                'notes' => 'Test payment 2',
            ]);
        }
    }
}
