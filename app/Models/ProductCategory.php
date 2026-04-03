<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ec_product_categories';

    /**
     * Get the products for the category.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'ec_product_category_product', 'category_id', 'product_id');
    }

    /**
     * Get the slug from the category name.
     */
    public function getSlugAttribute()
    {
        return Str::slug($this->name);
    }
}