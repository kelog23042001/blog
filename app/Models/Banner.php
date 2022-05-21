<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    public$timestamps=false;// set time to false
    protected $fillable = [
    'slider_name','slider_image','slider_status','slider_desc'
    ];
    protected $primarykey = 'slider_id';
    protected $table = 'tbl_slider';
}
