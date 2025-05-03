<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use App\Models\User;
use App\Services\Security\PBKDF2Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get non-admin users
        $users = User::where('is_admin', false)->get();

        // Skip if no users
        if ($users->isEmpty()) {
            Log::info('No users found for PaymentMethodSeeder');
            return;
        }

        foreach ($users as $user) {
            $this->createPaymentMethodsForUser($user);
        }

        Log::info('Payment methods seeded successfully');
    }

    /**
     * Create payment methods for a specific user
     */
    private function createPaymentMethodsForUser(User $user): void
    {
        // Create a credit card with standard encryption
        $creditCard = new PaymentMethod([
            'user_id' => $user->id,
            'name' => 'Kartu Kredit Utama',
            'type' => 'credit_card',
            'encrypted_details' => json_encode([
                'card_number' => '4111111111111111',
                'expiry_month' => '12',
                'expiry_year' => '25',
                'cvv' => '123',
                'card_holder' => $user->name,
            ]),
            'is_default' => true,
        ]);
        $creditCard->save();

        // Create a credit card with enhanced security (PBKDF2)
        $enhancedCard = new PaymentMethod([
            'user_id' => $user->id,
            'name' => 'Kartu Kredit dengan Keamanan Lanjutan',
            'type' => 'credit_card',
            'encrypted_details' => json_encode([
                'card_number' => '5555555555554444',
                'expiry_month' => '10',
                'expiry_year' => '27',
                'cvv' => '321',
                'card_holder' => $user->name,
            ]),
            'is_default' => false,
        ]);

        // Use PBKDF2 service for enhanced encryption of CVV
        try {
            $pbkdf2Service = app(PBKDF2Service::class);
            $enhancedCard->cvv_enhanced = '321';
            $enhancedCard->save();

            Log::info('Created payment method with enhanced security', [
                'user_id' => $user->id,
                'payment_method_id' => $enhancedCard->id
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to create enhanced payment method', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);
        }

        // Create a bank transfer method
        $bankTransfer = new PaymentMethod([
            'user_id' => $user->id,
            'name' => 'Transfer Bank',
            'type' => 'bank_transfer',
            'encrypted_details' => json_encode([
                'bank_name' => 'Bank Mandiri',
                'account_number' => '1234567890',
                'account_holder' => $user->name,
            ]),
            'is_default' => false,
        ]);
        $bankTransfer->save();
    }
}
