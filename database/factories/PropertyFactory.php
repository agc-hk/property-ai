<?php

namespace Database\Factories;

use App\Models\Property;
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
        $type = fake()->randomElement(['apartment', 'house', 'villa', 'plot', 'commercial']);
        $listing = fake()->randomElement(['sale', 'rent']);
        $beds = in_array($type, ['plot', 'commercial']) ? null : fake()->numberBetween(1, 5);

        return [
            'title' => ($beds ? $beds.' BHK ' : '').ucfirst($type).' in '.fake()->streetName(),
            'description' => fake()->paragraphs(3, true),
            'city' => fake()->randomElement(['Ahmedabad', 'Gandhinagar', 'Surat', 'Vadodara', 'Mumbai', 'Pune']),
            'locality' => fake()->streetName(),
            'type' => $type,
            'listing_type' => $listing,
            'price' => $listing === 'rent' ? fake()->numberBetween(8, 80) * 1000 : fake()->numberBetween(20, 500) * 100000,
            'bedrooms' => $beds,
            'bathrooms' => $beds ? min($beds, fake()->numberBetween(1, 4)) : null,
            'area_sqft' => fake()->numberBetween(400, 4000),
            'amenities' => fake()->randomElements(['parking', 'gym', 'pool', 'garden', 'lift', 'security', 'clubhouse'], fake()->numberBetween(1, 4)),
        ];
    }
}
