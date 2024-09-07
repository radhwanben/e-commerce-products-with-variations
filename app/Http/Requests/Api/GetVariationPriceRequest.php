<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GetVariationPriceRequest extends FormRequest
{
    // Hardcoded token for testing this can be env variable
    private $hardcodedToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxMjMsInJvbGUiOiJhZG1pbiIsImV4cCI6MTYzMzY0ODQwMH0.XYZ...';


      /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Check for Authorization header with Bearer token
        $authorizationHeader = $this->header('Authorization');

        if (!$authorizationHeader || $authorizationHeader !== 'Bearer ' . $this->hardcodedToken) {
            return false; // Unauthorized if token doesn't match
        }

        return true; // Authorized if token matches
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //'product_id' => 'required|integer|exists:products,id',
            'attribute_ids' => 'required|array',
            'attribute_ids.*' => 'integer|exists:attributes,id',
        ];
    }

    public function messages(): array
    {
        return [
            //'product_id.required' => 'Product ID is required.',
            'attribute_ids.required' => 'At least one attribute ID is required.',
            'attribute_ids.*.integer' => 'Each attribute ID must be an integer.',
        ];
    }
}
