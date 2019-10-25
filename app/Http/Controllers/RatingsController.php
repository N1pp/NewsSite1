<?php

namespace App\Http\Controllers;

use App\News;
use App\Ratings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function rate(Request $request){
        if(!(Ratings::where('user_id',Auth::user()->id)->where('news_id',$request->news_id))->get()->first()){
            Ratings::create($request->all());
            $rate = $request->value;
            $count = News::where('id',$request->news_id)->get()->first()->rate;
            $count = $count + $rate;
            $news = News::where('id',$request->news_id)->get()->first();
            $news->rate = $count ;
            $news->save();
            return redirect()->back();
        }
        return redirect()->back();
    }
}
