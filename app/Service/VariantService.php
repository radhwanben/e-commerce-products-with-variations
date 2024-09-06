<?php

namespace App\Service;

use App\Models\Product;
use App\Models\Variant;

class VariantService
{
    /**
     * Get the variant price based on product ID and attribute IDs.
     *
     * @param int $productId
     * @param array $attributeIds
     * @return Variant|null
     */
    public function getVariationPrice(int $productId, array $attributeIds): ?Variant
    {
        // Find the product
        $product = Product::find($productId);

        if (!$product) {
            return null;
        }

        // Query the variant that matches all the selected attributes
        $variant = Variant::where('product_id', $product->id)
            ->whereHas('attributeValues', function ($query) use ($attributeIds) {
                $query->whereIn('attribute_id', $attributeIds);
            }, '=', count($attributeIds))
            ->first();

        return $variant;
    }
}
