<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProductModel extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
    	'post_title', 'post_desc', 'post_content','post_meta_desc','post_meta_keywords', 'post_image', 'post_status', 'case_post_id'
    ];
    protected $primaryKey = 'post_id';
 	protected $table = 'tbl_posts';
}
