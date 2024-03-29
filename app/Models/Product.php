<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false; // set time to false
    protected $fillable = [
        'product_name',
        'product_tags',
        'product_quantity',
        'product_slug',
        'category_id',
        'brand_id',
        'product_desc',
        'product_content',
        'price_cost',
        'product_views',
        'product_price',
        'product_image',
        'product_status',
        'deleted',
    ];
    protected $primaryKey = 'product_id';
    protected $table = 'tbl_product';

    public function images()
    {
        return $this->hasMany(Gallery::class, 'product_id');
    }
    public function category()
    {
        return $this->belongsTo(CategoryProductModel::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand', 'brand_id');
    }
    public function rates()
    {
        return $this->hasMany(Rate::class, 'product_id');
    }
    public function comment()
    {
        return $this->hasMany(Comment::class)->orderBy('product_id', 'DESC');
    }
}
