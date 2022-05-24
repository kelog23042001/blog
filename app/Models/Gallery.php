<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    public$timestamps=false;// set time to false
    protected $fillable = [
    'gallery_image','gallery_name','product_id'
    ];
    protected $primarykey = 'gallery_id';
    protected $table = 'tbl_gallery';
}
