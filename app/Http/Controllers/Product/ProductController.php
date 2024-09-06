<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{

<<<<<<< Updated upstream
=======
    use ProductTrait,UploadImageTrait;
    
    public function __construct(
        private readonly Product $product,
        private readonly Attribute $attribute,
        private readonly Variant $variant
        )
    {}

>>>>>>> Stashed changes
    public function index()
    {

    }

    public function create()
    {
<<<<<<< Updated upstream
        return view('product.create');
=======
        $attributes = $this->attribute::with('values')->get();       
        
        return view('products.create', compact('attributes'));

>>>>>>> Stashed changes
    }

    public function store(StoreProductRequest $request)
    {
        // Handle the image upload if exists
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');  // Uploads to storage/app/public/products
        }

        // Create the product
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath
        ]);

        // Return response, for example redirecting back or sending JSON response
        return redirect()->back()->with('success', 'Product created successfully.');
    }
    
}