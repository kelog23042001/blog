<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialCustomer extends Model
{
    public $timestamps = false;
    protected $fillable = [
          'provider_user_id',  'provider',  'user', 'provider_user_email'
    ];

    protected $primaryKey = 'user_id';
 	protected $table = 'tbl_social_customer';
 	public function customer(){
 		return $this->belongsTo('App\Models\Customer', 'user');
 	}
}
