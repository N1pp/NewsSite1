@extends('layouts.app')
@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="content">
    <form method="POST" action="{{url('/create')}}" enctype="multipart/form-data">
        <div class="form-group">
            @csrf
                Введите заголовок:
                <input class="form-control" type="text" name="title">
        </div>
            <div class="form-group">
                Введите информацию:
                <input class="form-control" type="text" name="content">
            </div>
        <div class="form-group">
            Введите желаемые теги:
            <input class="form-control" type="text" name="tags" id="news-tags" style="width: 100vh">
        </div>
        <div class="form-group">
            Можете добавить картинку:
            <input type="file" name="img[]" multiple/>
        </div>
        <input type="hidden" name="user_id" value="{{\Illuminate\Support\Facades\Auth::id()}}">
        <button type="submit" class="btn btn-primary">Добавить</button>
    </form>
</div>
@endsection
