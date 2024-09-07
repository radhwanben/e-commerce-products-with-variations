<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Service\VariantService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GetVariationPriceRequest;

class ProductController extends Controller
{



    public function __construct(private readonly VariantService $variantService)
    {}

    public function getVariationPrice(GetVariationPriceRequest $request)
    {
        // The request is already validated and authorized at this point

        // Get validated data
        $validated = $request->validated();

        // Call the service to get the variant
        $variant = $this->variantService->getVariationPrice(
            $validated['attribute_ids']
        );

        if (!$variant) {
            return response()->json(['message' => 'No matching variant found'], 404);
        }

        // Return the price of the variant
        return response()->json([
            'variant_id' => $variant->id,
            'price' => $variant->price,
        ], 200);
    }
}
