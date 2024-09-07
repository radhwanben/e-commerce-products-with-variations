<?php

namespace App\Http\Traits;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProductRequest;



trait ProductTrait
{


    protected function createProduct($request, $imagePath)
    {
        return $this->product::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath,
            'created_by' => Auth::id(),
        ]);
    }


    protected function syncProductAttributes($product, $attributes)
    {
        if (isset($attributes) && is_array($attributes)) {
            $filteredAttributes = array_filter($attributes, function($value) {
                return !empty($value) && is_numeric($value);
            });

            if (!empty($filteredAttributes)) {
                $product->attributes()->sync($filteredAttributes);
            }
        }
    }

    protected function createProductVariants($product, $variants)
    {
        if (isset($variants) && is_array($variants)) {
            foreach ($variants as $variantData) {
                $variant = $this->variant::create([
                    'product_id' => $product->id,
                    'price' => $variantData['price'],
                    'stock' => $variantData['stock'],
                ]);
                if(isset($variantData['attributes']))
                {
                    $this->syncVariantAttributes($variant, $variantData['attributes']);
                }

            }
        }
    }
    protected function syncVariantAttributes($variant, $attributes): void
    {
        if (isset($attributes) && is_array($attributes)) {
            $filteredAttributes = array_filter($attributes, function($value) {
                return !empty($value) && is_numeric($value);
            });

            if (!empty($filteredAttributes)) {
                $variant->attributeValues()->sync($filteredAttributes);
            }
        }
    }
}
