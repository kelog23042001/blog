<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'imageUrl', 'product_id'
    ];
    protected $primaryKey = 'gallery_id';
    protected $table = 'tbl_gallery';

    public function Product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
