<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rate extends Model
{
    use HasFactory;
    // public $timestamps = false;
    protected $fillable = [
        'product_id', 'rating', 'user_id', 'comment', 'created_at', 'updated_at', 'visible'
    ];
    protected $primaryKey = 'rating_id';
    protected $table = "tbl_rating";

    public function user()
    {
        return $this->BelongsTo(User::class);
    }
    public function product()
    {
        return $this->BelongsTo(Product::class);
    }
}
