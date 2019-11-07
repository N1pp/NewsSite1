<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsCreateRequest;
use App\Sub;
use App\User;
use App\Image;
use App\NewsTags;
use App\Notifications\NewPost;
use \App\Tags;
use App\Jobs\SendEmail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use \App\News;
use \App\Ratings;
use \App\Comment;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::all()->sortByDesc('created_at');
        return view('news.index', compact('news'));
    }

    public function showArticle($id)
    {
        $new = News::where('id', $id)->first();
        return view('news.show', compact('new'));
    }

    public function createNews(NewsCreateRequest $request)
    {

        $news = News::create($request->all());
        $news->save();

        $images = $request->file('img');
        if($images){
            foreach ($images as $im){
                $path = $im->store('uploads', 'public');
                $img = new Image();
                $img->path = $path;
                $img->news_id = $news->id;
                $img->save();
            }
        }

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

        SendEmail::dispatch($news)->onQueue('email');

        return redirect()->route('news', [$news]);
    }

    public function findNewsByTag($id)
    {
        $tag = \App\Tags::find($id);
        $news = $tag->news;
        return view('news.index',compact('news'));
    }

    public function findNewsByAuthor($id)
    {
        $news = News::where('user_id',$id)->get();
        return view('news.index',compact('news'));
    }

    public function deleteNews(Request $request)
    {
        News::where('id', $request->news_id)->delete();
        foreach (Image::where('news_id',$request->news_id)->get() as $image){
            Storage::delete('public/' . $image->path);
            $image->delete();
        }
        return redirect('/home');
    }

    public function createView()
    {
        return view('create');
    }
}
