<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // use HasFactory;
    public $timestamps = false; // set time to false
    protected $fillable = [
        'comment', 'comment_name', 'comment_date', 'comment_product_id','comment_status'
    ];
    protected $primaryKey = "comment_id";
    protected $table = 'tbl_comment';
}
