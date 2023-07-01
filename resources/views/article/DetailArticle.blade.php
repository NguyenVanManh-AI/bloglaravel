@extends('dashboard')

@section('content')
<div class="col-6 mx-auto">
    <div class="alert alert-primary text-center" role="alert">
        Detail Article 
    </div>
    {{-- <form method="POST" action="/article/add"> nếu không đặt name cho route --}} 
        @csrf
        <input hidden value="{{ old('id', $article->id) }}" name="id" type="text" class="form-control" id="id_article" aria-describedby="titleHelp" placeholder="Title">
        <div class="form-group">
            <label for="title">Title</label>
            <input value="{{ $article->title }}" name="title" type="text" class="form-control" id="title" aria-describedby="titleHelp" placeholder="Title">
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" class="form-control" id="content" rows="5" placeholder="Content">{{ $article->content }}</textarea>
        </div>
        @if($article->id_user == auth()->user()->id)
        <a href="{{ route('article.show-edit', ['id' => $article->id]) }}" class="btn btn-primary">
            <i class="fa-solid fa-pen-to-square"></i> Edit
        </a>
        @endif 
</div>
@endsection