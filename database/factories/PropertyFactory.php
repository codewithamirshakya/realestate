<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cities = ['Lalitpur', 'Kathmandu', 'Bhaktapur', 'Kirtipur', 'Bhaisepati', 'Godawari'];
        $category = fake()->randomElement(['house', 'apartment', 'land', 'commercial']);
        $listingType = fake()->randomElement(['sale', 'sale', 'sale', 'rent']);

        $title = match ($category) {
            'land' => fake()->numberBetween(2, 12).' Aana Land in '.fake()->randomElement($cities),
            'apartment' => fake()->numberBetween(2, 4).' BHK Apartment in '.fake()->randomElement($cities),
            'commercial' => 'Commercial Space in '.fake()->randomElement($cities),
            default => fake()->numberBetween(2, 6).' Bedroom House in '.fake()->randomElement($cities),
        };

        $price = match ($category) {
            'land' => fake()->numberBetween(30, 250) * 100000,
            'commercial' => fake()->numberBetween(80, 500) * 100000,
            default => $listingType === 'rent'
                ? fake()->numberBetween(15, 120) * 1000
                : fake()->numberBetween(50, 600) * 100000,
        };

        return [
            'user_id' => User::factory()->agent(),
            'title' => $title,
            'description' => fake()->paragraphs(3, true),
            'listing_type' => $listingType,
            'category' => $category,
            'status' => fake()->randomElement(['available', 'available', 'available', 'pending', 'sold']),
            'price' => $price,
            'area_sqft' => $category === 'land' ? null : fake()->numberBetween(600, 4500),
            'bedrooms' => in_array($category, ['house', 'apartment']) ? fake()->numberBetween(1, 6) : null,
            'bathrooms' => in_array($category, ['house', 'apartment']) ? fake()->numberBetween(1, 4) : null,
            'parking' => fake()->numberBetween(0, 3),
            'address' => fake()->streetAddress(),
            'city' => fake()->randomElement($cities),
            'featured' => fake()->boolean(20),
        ];
    }
}
