<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CommentCreateRequest;
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
    public function comment(CommentCreateRequest $request){
        $com = new Comment();
        $com->user_id = \Illuminate\Support\Facades\Auth::id();
        $com->content = $request->cont;
        $com->news_id = $request->news_id;
        $com->save;
        $count = Comment::where('news_id',$request->news_id)->count();
        $new = News::where('id',$request->news_id)->get()->first();
        $new->comments = $count;
        $new->save();
        return redirect()->back();
    }
}
