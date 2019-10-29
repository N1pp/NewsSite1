<?php

namespace App\Http\Controllers;

use App\Sub;
use App\User;
use App\Image;
use App\NewsTags;
use App\Notifications\NewPost;
use \App\Tags;
use App\Jobs\SendMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use \App\News;
use \App\Ratings;
use \App\Comment;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::all();
        return view('news.index', compact('news'));
    }

    public function show($id)
    {
        $new = News::where('id', $id)->first();
        return view('news.show', compact('new'));
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required'
        ]);
        if ($validator->errors()->any()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator);
        }
        $images = $request->file('img');
        $news = News::create($request->all());
        if($images){
            foreach ($images as $im){
                $path = $im->store('uploads', 'public');
                $img = new Image();
                $img->path = $path;
                $img->news_id = $news->id;
                $img->save();
            }
        }
        $news->save();

        $tags = explode(',', $request->tags);
        foreach ($tags as $str) {
            if(Tags::where('name',trim($str))->get()->first()){
                $nt = new NewsTags;
                $nt->news_id = $news->id;
                $nt->tags_id = Tags::where('name',trim($str))->get()->first()->id;
                $nt->save();
            }else{
                $tag = new Tags;
                $tag->name = trim($str);
                $tag->save();
                $nt = new NewsTags;
                $nt->news_id = $news->id;
                $nt->tags_id = Tags::where('name',trim($str))->get()->first()->id;
                $nt->save();
            }
        }
        foreach (Sub::where('auth_id',$request->user_id)->get() as $sub){
            //SendMail::dispatch(User::find($sub->user_id)->first(),$news,User::find($news->user_id)->name,'/news/' . $news->id);
            SendMail::dispatch(User::find($sub->user_id)->first(),new NewPost($news,User::find($news->user_id)->name,'/news/' . $news->id));
            //User::find($sub->user_id)->notify(new NewPost($news,User::find($news->user_id)->name,'/news/' . $news->id));
        }
        return redirect()->route('news', [$news]);
    }

    public function findTag($id){
        $tags = \App\Tags::where('id', $id)->get()->first();
        $news = $tags->news;
        return view('news.index',compact('news'));
    }
    public function findAuth($id){
        $news = News::where('user_id',$id)->get();
        return view('news.index',compact('news'));
    }

    public function delete(Request $request){
        NewsTags::where('news_id',$request->news_id)->delete();
        News::where('id', $request->news_id)->delete();
        Comment::where('news_id',$request->news_id)->delete();
        Ratings::where('news_id',$request->news_id)->delete();
        //Storage::delete(Image::where('news_id',$request->news_id)->first()->path);
        Image::where('news_id',$request->news_id)->delete();
        return redirect('/home');
    }

    public function createW()
    {
        return view('create');
    }
}
