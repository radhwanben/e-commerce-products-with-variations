<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'image','created_by'];

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'products_attributes', 'product_id', 'attribute_id');
    }

    public function productsAttributes()
    {
        return $this->hasMany(ProductsAttributes::class);
    }
}
