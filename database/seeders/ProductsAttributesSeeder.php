<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Attribute;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductsAttributesSeeder extends Seeder
{
    public function run()
    {
        // Retrieve all products and attributes
        $products = Product::all();
        $attributes = Attribute::all();

        // Seed the products_attributes table without truncating
        foreach ($products as $product) {
            foreach ($attributes as $attribute) {
                // Check if the record already exists to avoid duplication
                if (!DB::table('products_attributes')
                        ->where('product_id', $product->id)
                        ->where('attribute_id', $attribute->id)
                        ->exists()) {
                    DB::table('products_attributes')->insert([
                        'product_id' => $product->id,
                        'attribute_id' => $attribute->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
