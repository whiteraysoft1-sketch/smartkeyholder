<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'key' => 'site_name',
                'value' => 'Whiteray Smart Tag',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Website name'
            ],
            [
                'key' => 'site_description',
                'value' => 'Smart digital identity powered by permanent QR codes. Claim your profile, share your vCard, and manage your digital presence—anywhere, anytime.',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Website description'
            ],
            [
                'key' => 'contact_email',
                'value' => 'admin@whiteraysmartag.com',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Contact email address'
            ],
            [
                'key' => 'contact_phone',
                'value' => '+1-234-567-8900',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Contact phone number'
            ],
            [
                'key' => 'trial_days',
                'value' => '30',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Trial period in days'
            ],

            // Payment Settings
            [
                'key' => 'subscription_price',
                'value' => '9.99',
                'type' => 'string',
                'group' => 'payment',
                'description' => 'Monthly subscription price'
            ],
            [
                'key' => 'qr_code_price',
                'value' => '5.00',
                'type' => 'string',
                'group' => 'payment',
                'description' => 'QR code purchase price'
            ],
            [
                'key' => 'flutterwave_environment',
                'value' => 'sandbox',
                'type' => 'string',
                'group' => 'payment',
                'description' => 'Flutterwave Environment'
            ],
            [
                'key' => 'paypal_environment',
                'value' => 'sandbox',
                'type' => 'string',
                'group' => 'payment',
                'description' => 'PayPal Environment'
            ],

            // Currency Settings
            [
                'key' => 'default_currency',
                'value' => 'USD',
                'type' => 'string',
                'group' => 'currency',
                'description' => 'Default currency code'
            ],
            [
                'key' => 'currency_symbol',
                'value' => '$',
                'type' => 'string',
                'group' => 'currency',
                'description' => 'Currency symbol'
            ],
            [
                'key' => 'currency_position',
                'value' => 'before',
                'type' => 'string',
                'group' => 'currency',
                'description' => 'Currency symbol position'
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}