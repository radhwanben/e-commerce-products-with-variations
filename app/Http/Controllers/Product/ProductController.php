<?php

namespace App\Http\Controllers\Product;

use App\Http\Requests\Product\StoreProductRequest;
use App\Models\Product;
use App\Models\Variant;
use App\Models\Attribute;
use App\Http\Traits\ProductTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\UploadImageTrait;

class ProductController extends Controller
{

    use ProductTrait, UploadImageTrait;

    public function __construct(
        private  readonly Product $product,
        private  readonly Attribute $attribute,
        private readonly Variant $variant
    )
    {
    }

    public function index()
    {

        $products = $this->product::with(['variants.attributeValues.attribute'])
        ->where('created_by', Auth::id()) // filter the product to show only the one who created  by the auth user
        ->paginate(10);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $attributes = $this->attribute::with('values')->get();

        return view('products.create', compact('attributes'));

    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        //dd($request);
        $imagePath = $this->handleImageUpload($request);

        $product = $this->createProduct($request, $imagePath);

        $this->syncProductAttributes($product, $request->attributes);

        $this->createProductVariants($product, $request->variants);

        return redirect()->back()->with('success', 'Product created successfully.');
    }



}
