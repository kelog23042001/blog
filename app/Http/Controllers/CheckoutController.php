<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function manage_order(){
        return view('admin.manage_order');
    }
}
