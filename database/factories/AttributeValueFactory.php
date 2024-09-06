<?php

namespace Database\Factories;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AttributeValue>
 */
class AttributeValueFactory extends Factory
{
    protected $model = AttributeValue::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'attribute_id' => function () {
                return Attribute::inRandomOrder()->first()->id;
            },
            'value' => $this->faker->randomElement(['Red', 'Blue', 'Small', 'Large', 'Cotton', 'Leather']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
