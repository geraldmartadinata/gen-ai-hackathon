<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => Category::factory(),
            'name' => $this->faker->words(3, true),
            'price' => $this->faker->numberBetween(10000, 1000000),
            'quantity' => $this->faker->numberBetween(1, 100),
            'photo' => 'items/' . $this->faker->uuid() . '.jpg',
        ];
    }
}
