<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Image validation
            'attributes' => 'nullable|array',
            'attributes.*' => 'exists:attributes_values,id', // Ensure each attribute ID exists in the attribute values table
            'variants' => 'nullable|array',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.stock' => 'required|integer|min:0',
            'variants.*.attributes' => 'nullable|array',
            'variants.*.attributes.*' => 'exists:attributes_values,id', // Ensure each attribute value ID exists in the attribute values table
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The product name is required.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'Allowed image formats are jpeg, png, jpg, gif, svg.',
            'image.max' => 'The image may not be greater than 2MB.',
            'attributes.*.exists' => 'One or more selected attributes do not exist.',
            'variants.*.price.required' => 'The price is required for each variant.',
            'variants.*.stock.required' => 'The stock is required for each variant.',
            'variants.*.attributes.*.exists' => 'One or more selected attribute values for variants do not exist.',
        ];
    }

}
