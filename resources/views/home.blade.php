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

                    You are logged in,{{Auth::user()->name}}
                    !<br> Your articles:
                        @foreach(Auth::user()->news as $new)
                            <li>
                                <a href="news/{{$new->id}}"><strong style="font-size: 40px">{{$new->title}}</strong></a>
                                <form method="POST" action="{{url('/delete')}}">
                                    @csrf
                                    <input type="hidden" name="news_id" value="{{$new->id}}">
                                    <button type="submit"class="btn-danger">Delete</button>
                                </form>
                            </li>
                        @endforeach
                        <br> Your subscriptions:
                        @foreach(App\Sub::where('user_id',Auth::id())->get() as $sub)
                            <li>
                                <a href="/findAuth/{{$sub->user_id}}"><strong style="font-size: 40px">{{App\User::find($sub->auth_id)->name}}</strong></a>
                                <form method="POST" action="{{url('/news/editSub')}}">
                                    @csrf
                                    <input type="hidden" name="key" value="0">
                                    <input type="hidden" name="auth_id" id="auth_id" value="{{$sub->auth_id}}">
                                    <input type="hidden" name="user_id" id="user_id" value="{{\Illuminate\Support\Facades\Auth::id()}}">
                                    <button class="btn-light"type="submit">Unsubscribe</button>
                                </form>
                            </li>
                        @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
