<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Service\VariantService;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{

    // Hardcoded token for testing this can be env variable 
    private $hardcodedToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxMjMsInJvbGUiOiJhZG1pbiIsImV4cCI6MTYzMzY0ODQwMH0.XYZ...';

    public function __construct(private readonly VariantService $variantService)
    {}

    public function getVariationPrice(Request $request)
    {

        // Check for Authorization header with Bearer token
         $authorizationHeader = $request->header('Authorization');

        if (!$authorizationHeader || $authorizationHeader !== 'Bearer ' . $this->hardcodedToken) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }


        // Validate the incoming request
        $validated = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'attribute_ids' => 'required|array',
            'attribute_ids.*' => 'integer|exists:attributes,id',
        ]);
        
        // Call the service to get the variant
        $variant = $this->variantService->getVariationPrice(
            $validated['product_id'], 
            $validated['attribute_ids']
        );

        if (!$variant) {
            return response()->json(['message' => 'No matching variant found'], 404);
        }

        // Return the price of the variant
        return response()->json([
            'variant_id' => $variant->id,
            'price' => $variant->price,
        ],200);
    }
}