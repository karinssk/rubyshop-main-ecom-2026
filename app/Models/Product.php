<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ec_products';

    /**
     * Get the categories for the product.
     */
    public function categories()
    {
        return $this->belongsToMany(ProductCategory::class, 'ec_product_category_product', 'product_id', 'category_id');
    }

    /**
     * Get the slug from the product name.
     */
    public function getSlugAttribute()
    {
        return Str::slug($this->name);
    }
}
