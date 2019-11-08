<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsCreateRequest;
use App\Image;
use App\NewsTags;
use App\Repositories\RepositoryNews;
use \App\Tags;
use App\Jobs\SendEmail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use \App\News;

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
        $data = array();
        $data['title'] = $request->title;
        $data['content'] = $request->cont;
        $repos = new RepositoryNews($data, $request->tags,$request->file('img'));
        $news = $repos->getNews();

        SendEmail::dispatch($news)->onQueue('email');

        return redirect()->route('news', [$news]);
    }

    public function findNewsByTag($id)
    {
        $tag = \App\Tags::find($id);
        $news = $tag->news;
        return view('news.index', compact('news'));
    }

    public function findNewsByAuthor($id)
    {
        $news = News::where('user_id', $id)->get();
        return view('news.index', compact('news'));
    }

    public function deleteNews(Request $request)
    {
        RepositoryNews::deleteNews($request->news_id);
        return redirect('/home');
    }

    public function createView()
    {
        return view('create');
    }
}
