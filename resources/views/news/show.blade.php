@extends('layouts.app')
<?php use App\User; ?>
@section('content')
<div class="container">
    <div class="border-bottom border-dark">
        <div class="row">
            @if($new->images)
                @foreach($new->images as $image)
                    <div class="col">
                        <img class="img" src="{{asset('/storage/' . $image->path)}}">
                    </div>
                @endforeach
            @endif
        </div>
        <div class="row justify-content-md-center">
            <div class="col-lg-10">
                <h1>Title: {{$new->title}}</h1>
            </div>
            <div class="col-1">
                Autor: <a href="/news/findByAuthor/{{User::find($new->user_id)->name}}">{{User::find($new->user_id)->name}}</a>
            </div>
            @if(\Illuminate\Support\Facades\Auth::id()==$new->user_id)
                <div class="col-1">You are author</div>
            @elseif(!App\Sub::where('user_id',\Illuminate\ Support\Facades\Auth::id())->where('author_id',$new->user_id)->get()->first())
                <div class="col-1">
                    <form method="POST" action="{{url('/news/editSub')}}">
                        @csrf
                        <input type="hidden" name="key" value="1">
                        <input type="hidden" name="author_id" id="author_id" value="{{$new->user_id}}">
                        <input type="hidden" name="user_id" id="user_id" value="{{\Illuminate\Support\Facades\Auth::id()}}">
                        <button class="btn-info"type="submit">Subscribe</button>
                    </form>
                </div>
            @else
                <div class="col-1">
                <form method="POST" action="{{url('/news/editSub')}}">
                    @csrf
                    <input type="hidden" name="key" value="0">
                    <input type="hidden" name="author_id" id="author_id" value="{{$new->user_id}}">
                    <input type="hidden" name="user_id" id="user_id" value="{{\Illuminate\Support\Facades\Auth::id()}}">
                    <button class="btn-light"type="submit">Unsubscribe</button>
                </form>
            </div>
            @endif
        </div>
        <div class="row">
            <div class="col-4">
                Tags:
                @foreach($new->tags()->get() as $tags)
                    <a href="/news/findByTag/{{$tags->id}}">{{$tags->name.' '}}</a>|
                @endforeach
            </div>
        </div>
        <div class="row">
            <div class="col-1">
                Rating:{{$new->rate}}
            </div>
            <div class="col-11">
                {{$new->content}}
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                Date:{{$new->created_at}}
            </div>
        </div>
        <div class="row">
            <div class="col-1">
                <form method="POST" action="{{url('/news/editRate')}}">
                    @csrf
                    <input type="hidden" name="value" value="1">
                    <input type="hidden" name="news_id" id="news" value="{{$new->id}}">
                    <input type="hidden" name="user_id" id="user_id" value="{{\Illuminate\Support\Facades\Auth::id()}}">
                    <input type="hidden" name="key" id="key" value="0">
                    <button class="btn-success" type="submit">Like</button>
                </form>
            </div>
            <div class="col-1">
                <form method="POST" action="{{url('/news/editRate')}}">
                    @csrf
                    <input type="hidden" name="value" value="-1">
                    <input type="hidden" name="news_id" id="news" value="{{$new->id}}">
                    <input type="hidden" name="user_id" id="user_id" value="{{\Illuminate\Support\Facades\Auth::id()}}">
                    <input type="hidden" name="key" id="key" value="0">
                    <button class="btn-danger"type="submit">Dislike</button>
                </form>
            </div>
        </div>
    </div>
    <div class="alert-danger">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
        Comments:
        <?php $comments = \App\Comment::where('news_id',$new->id)->get();?>
        @foreach($comments as $comment)
            <div class="container border-bottom border-dark">
                {{$comment->content}}<br>Author: {{\App\User::where('id',$comment->user_id)->get()->first()->name}}
            </div>
        @endforeach
    <form method="POST" action="{{url('/news/editComment')}}">
        @csrf
        <input type="text" name="content" id="content">
        <input type="hidden" name="news_id" id="news_id" value="{{$new->id}}">
        <input type="hidden" name="user_id" id="user_id" value="{{\Illuminate\Support\Facades\Auth::id()}}">
        <input type="hidden" name="key" id="key" value="1">
        <button type="submit">Add comment</button>
    </form>
</div>
</div>
@endsection
