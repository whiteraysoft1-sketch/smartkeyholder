<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class CurrencySettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencySettings = [
            [
                'key' => 'default_currency',
                'value' => 'USD',
                'type' => 'string',
                'group' => 'payment',
                'description' => 'Default currency for payments and pricing'
            ],
            [
                'key' => 'currency_symbol',
                'value' => '$',
                'type' => 'string',
                'group' => 'payment',
                'description' => 'Currency symbol to display'
            ],
            [
                'key' => 'currency_position',
                'value' => 'before',
                'type' => 'string',
                'group' => 'payment',
                'description' => 'Position of currency symbol (before/after)'
            ],
            [
                'key' => 'supported_currencies',
                'value' => json_encode(['USD', 'EUR', 'GBP', 'NGN', 'KES', 'GHS', 'ZAR']),
                'type' => 'json',
                'group' => 'payment',
                'description' => 'List of supported currencies'
            ],
            [
                'key' => 'auto_currency_detection',
                'value' => true,
                'type' => 'boolean',
                'group' => 'payment',
                'description' => 'Automatically detect user currency based on location'
            ]
        ];

        foreach ($currencySettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('Currency settings seeded successfully!');
    }
}