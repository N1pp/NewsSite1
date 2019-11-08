<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingCreateRequest;
use App\News;
use App\Ratings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingsController extends Controller
{
    public function rate(RatingCreateRequest $request)
    {
        if (!(Ratings::where('user_id', Auth::user()->id)->where('news_id', $request->news_id))->get()->first()) {
            $rating = new Ratings;
            $rating->news_id = $request->news_id;
            $rating->value = $request->value;
            $rating->user_id = \Illuminate\Support\Facades\Auth::id();
            $rating->save();
            $rate = $request->value;
            $count = News::where('id', $request->news_id)->get()->first()->rate;
            $count = $count + $rate;
            $news = News::where('id', $request->news_id)->get()->first();
            $news->rate = $count;
            $news->save();
            return redirect()->back();
        }
        return redirect()->back();
    }
}
