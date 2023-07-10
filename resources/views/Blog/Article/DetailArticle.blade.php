@extends('Blog.Layouts.ViewContent')
@section('content-blog')
<br>
<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto:display=swap');
    #p_title {
        font-size: 26px;
        color: #0085FF;
        text-align: center;
        font-family: 'Roboto', sans-serif;
        font-weight: bold;
        font-style: italic;
    }
    #div_content {
        padding: 5px 15px;
        box-shadow: rgba(17, 17, 26, 0.05) 0px 1px 0px, rgba(17, 17, 26, 0.1) 0px 0px 8px;
    }
    #a-btn-edit {
        display: flex;
        width: 50px;
        height: 50px;
        justify-content: center;
        align-items: center;
        border-radius: 25px;
        font-size: 20px;
        position: fixed;
        right: 80px;
        bottom: 80px;
        z-index: 999;
    }
</style>
<div class="col-12 mx-auto">
    {{-- <form method="POST" action="/article/add"> nếu không đặt name cho route --}} 
        @csrf
        {{-- <input hidden value="{{ old('id', $article->id) }}" name="id" type="text" class="form-control" id="id_article" aria-describedby="titleHelp" placeholder="Title"> --}}
        <div class="form-group">
            <p id="p_title"><label style="margin-right: 10px" for="title"><i class="fa-solid fa-blog"></i></label> {{ $article->title }}</p>
            {{-- <input value="" name="title" type="text" class="form-control" id="title" aria-describedby="titleHelp" placeholder="Title"> --}}
        </div>
        <div class="form-group">
            <div id="div_content">
                {{-- {{$article->content}} --}}{{-- CÁCH HIỂN THỊ TEXT --}}
                {!! $article->content !!}{{-- CÁCH HIỂN THỊ HTML --}}
            </div>
            {{-- <textarea name="content" class="form-control" id="content" rows="5" placeholder="Content">{{ $article->content }}</textarea> --}}
        </div>
        @if($article->id_user == auth()->user()->id)
        <a id="a-btn-edit" href="{{ route('blog.show-edit', ['id' => $article->id]) }}" class="btn btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i> </a>
        @endif 
</div>
@endsection