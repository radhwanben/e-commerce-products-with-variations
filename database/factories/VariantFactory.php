<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Variant>
 */
class VariantFactory extends Factory
{
    protected $model = Variant::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(), 
            'stock' => $this->faker->numberBetween(1, 100), 
            'price' => $this->faker->randomFloat(2, 10, 500), 
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
