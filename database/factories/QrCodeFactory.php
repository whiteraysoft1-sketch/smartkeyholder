<?php

namespace Database\Factories;

use App\Models\QrCode;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class QrCodeFactory extends Factory
{
    protected $model = QrCode::class;

    public function definition(): array
    {
        $uuid = Str::uuid();
        
        return [
            'code' => strtoupper($this->faker->bothify('QR####??')),
            'uuid' => $uuid,
            'url' => "http://localhost/qr/{$uuid}",
            'is_active' => true,
            'user_id' => null,
            'claimed_at' => null,
            'scan_count' => 0,
            'last_scanned_at' => null,
        ];
    }

    public function claimed(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => User::factory(),
            'claimed_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}