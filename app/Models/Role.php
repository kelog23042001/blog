<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'name',
    ];

    protected $primaryKey = 'id';
    protected $table = 'roles';

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'role_id', 'id');
    }
}
