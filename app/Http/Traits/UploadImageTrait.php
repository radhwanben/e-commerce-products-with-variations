<?php

namespace App\Http\Traits;

trait UploadImageTrait
{
    protected function handleImageUpload($request)
    {
        if ($request->hasFile('image')) {
            return $request->file('image')->store('products', 'public'); // Uploads to storage/app/public/products
        }
        
        return null;
    }
}