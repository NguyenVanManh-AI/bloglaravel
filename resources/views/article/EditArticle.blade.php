@extends('dashboard')

@section('content')
<div class="col-6 mx-auto">
    <div class="alert alert-primary text-center" role="alert">
        Edit Article 
    </div>
    {{-- <form method="POST" action="/article/add"> nếu không đặt name cho route --}} 
    <form method="POST" action="{{ route('article.update') }}">
        @csrf
        <input hidden value="{{ old('id', $article->id) }}" name="id" type="text" class="form-control" id="id_article" aria-describedby="titleHelp" placeholder="Title">
        <div class="form-group">
            <label for="title">Title</label>
            <input value="{{ old('title', $article->title) }}" name="title" type="text" class="form-control" id="title" aria-describedby="titleHelp" placeholder="Title">
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" class="form-control" id="content" rows="5" placeholder="Content">{{ old('content', $article->content) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i> Update</button>
    </form>
</div>
@endsection