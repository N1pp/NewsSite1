@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in,
                        <?php
                            echo Auth::user()->name;
                            $news = Auth::user()->news;
                        ?>
                    !<br> Your articles:
                        @foreach($news as $new)
                            <li>
                                <a href="news/{{$new->id}}"><strong style="font-size: 40px">{{$new->title}}</strong></a>
                                <form method="POST" action="{{url('/delete')}}">
                                    @csrf
                                    <input type="hidden" name="news_id" value="{{$new->id}}">
                                    <button type="submit"class="btn-danger">Delete</button>
                                </form>
                            </li>
                        @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
