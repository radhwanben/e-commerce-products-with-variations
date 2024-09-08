<?php

namespace App\Http\Traits;


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
            // Ensure that only numeric attribute IDs are included
            $filteredAttributes = array_filter($attributes, function($value) {
                return is_numeric($value);
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
                $this->createProductVariant($product, $variantData['price'], $variantData['stock'], $variantData['attributes']);
            }
        }
    }

    protected function createProductVariant($product, $price, $stock, $attributes)
    {
        $variant = $this->variant::create([
            'product_id' => $product->id,
            'price' => $price,
            'stock' => $stock,
        ]);

        if (isset($attributes) && is_array($attributes)) {
            $this->syncVariantAttributes($variant, $attributes);
        }
    }

    protected function syncVariantAttributes($variant, $attributes): void
    {
        if (isset($attributes) && is_array($attributes)) {
            // Ensure that only numeric attribute values are included
            $filteredAttributes = array_filter(array_keys($attributes), function($value) {
                return is_numeric($value);
            });

            if (!empty($filteredAttributes)) {
                $variant->attributeValues()->sync($filteredAttributes);
            }
        }
    }
}
