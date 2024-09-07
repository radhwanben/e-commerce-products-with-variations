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
     */
    public function getVariationPrice(array $attributeIds)
    {


        return Variant::whereHas('attributeValues', function ($query) use ($attributeIds) {
            $query->whereIn('attribute_value_id', $attributeIds);
        }, '=', count($attributeIds)) // Ensure that the count of matched attributes equals the provided attributes
        ->first();
    }
}
