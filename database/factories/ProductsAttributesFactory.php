<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductsAttributes>
 */
class ProductsAttributesFactory extends Factory
{
    protected $model = \App\Models\ProductsAttributes::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'attribute_id' => A ttribute::factory(),
        ];
    }
}
