<?php

namespace App\Http\Controllers;

use App\Comment;
use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function comment(Request $request){
        $validator = Validator::make($request->all(),[
            'content'=> 'required',
        ]);
        if($validator->errors()->any()){
            return redirect()->back()
                ->withInput()
                ->withErrors($validator);
        }
        Comment::create($request->all());
        $count = Comment::where('news_id',$request->news_id)->count();
        $new = News::where('id',$request->news_id)->get()->first();
        $new->comments = $count;
        $new->save();
        return redirect()->back();
    }
}
