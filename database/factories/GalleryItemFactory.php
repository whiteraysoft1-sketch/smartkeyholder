<?php

namespace Database\Factories;

use App\Models\GalleryItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GalleryItemFactory extends Factory
{
    protected $model = GalleryItem::class;

    public function definition(): array
    {
        $imagePath = 'gallery-images/' . $this->faker->uuid() . '.jpg';
        
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(),
            'image_path' => $imagePath,
            'image_url' => asset('storage/' . $imagePath),
            'sort_order' => 0,
            'is_active' => true,
        ];
    }
}