@extends('layouts.app')
<?php use App\User;?>
@section('content')
<div class="container" >
    @if($news->count()>0)
        @foreach($news as $new)
            <div class="container border border-dark rounded" style="background-color: #2ffff7">
                    <div class="row">
                        <div class="col-1">Rating:{{$new->rate}}</div>
                        <div class="col-10"><h1><a href="/news/{{$new->id}}">{{$new->title}}</a></h1></div>
                        <div class="col-1">Autor: <a href="/findAuth/{{$new->user_id}}">{{User::find($new->user_id)->name}}</a></div>
                    </div>
                    <div class="row">
                        <div class="col">{{$new->content}}</div>
                    </div>
                    <div class="row">
                        <div class="col-1">Comments:{{$new->comments}}</div>
                        <div class="col-8">Tags:
                            @foreach($new->tags as $tags)
                                <a href="/findTag/{{$tags->id}}">{{$tags->name.' '}}</a>|
                            @endforeach
                        </div>
                        <div class="col-3">Date:{{$new->created_at}}</div>
                    </div>
            </div>
        @endforeach

    @else No available news :(
    @endif
</div>
@endsection
