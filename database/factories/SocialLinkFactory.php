<?php

namespace Database\Factories;

use App\Models\SocialLink;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SocialLinkFactory extends Factory
{
    protected $model = SocialLink::class;

    public function definition(): array
    {
        $platforms = ['facebook', 'twitter', 'instagram', 'linkedin', 'youtube', 'tiktok', 'whatsapp', 'website'];
        $platform = $this->faker->randomElement($platforms);
        
        return [
            'user_id' => User::factory(),
            'platform' => $platform,
            'url' => $this->generateUrlForPlatform($platform),
            'display_name' => $this->faker->userName(),
            'is_active' => true,
            'sort_order' => 0,
        ];
    }

    private function generateUrlForPlatform(string $platform): string
    {
        $username = $this->faker->userName();
        
        return match ($platform) {
            'facebook' => "https://facebook.com/{$username}",
            'twitter' => "https://twitter.com/{$username}",
            'instagram' => "https://instagram.com/{$username}",
            'linkedin' => "https://linkedin.com/in/{$username}",
            'youtube' => "https://youtube.com/@{$username}",
            'tiktok' => "https://tiktok.com/@{$username}",
            'whatsapp' => "https://wa.me/1234567890",
            'website' => $this->faker->url(),
            default => $this->faker->url(),
        };
    }
}