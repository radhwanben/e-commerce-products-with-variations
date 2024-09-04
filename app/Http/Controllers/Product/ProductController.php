<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;

class ProductController extends Controller
{

    public function index()
    {

    }

    public function create()
    {
        return view('product.create');
    }

    public function store()
    {
        
    }
    
}