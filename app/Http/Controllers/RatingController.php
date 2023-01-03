<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Rate;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function show_rating(){
        $rates = Rate::orderBy('rating_id', 'ASC')->get();
        return view('admin.rating.all_rating', compact('rates'));
    }

    public function unactive_rating($rating_id)
    {
        Rate::where('rating_id', $rating_id)->update(['visible' => 0]);
        return redirect('/all-rating');
    }

    public function active_rating($rating_id)
    {
        Rate::where('rating_id', $rating_id)->update(['visible' => 1]);
        return redirect('/all-rating');
    }
}
