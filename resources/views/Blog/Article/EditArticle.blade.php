@extends('Blog.Layouts.ViewContent')
@section('content-blog')
<style>
    .title_blog {
        text-transform: uppercase;
        font-size: 20px;
        font-weight: bold;
        color: rgb(107, 107, 107);
    }
    #submit-btn-edit {
        display: flex;
        width: 50px;
        height: 50px;
        justify-content: center;
        align-items: center;
        border-radius: 25px;
        font-size: 20px;
        position: fixed;
        right: 100px;
        bottom: 110px;
        z-index: 999;
    }
</style>
<div class="col-12 mx-auto">
    {{-- <form method="POST" action="/article/add"> nếu không đặt name cho route --}} 
    <form method="POST" action="{{ route('blog.update') }}">
        @csrf
        <input hidden value="{{ old('id', $article->id) }}" name="id" type="text" class="form-control" id="id_article" aria-describedby="titleHelp" placeholder="Title">
        <div class="form-group">
            <label for="title" class="title_blog"><i class="fa-solid fa-blog"></i> Title</label>
            <input value="{{ old('title', $article->title) }}" name="title" type="text" class="form-control" id="title" aria-describedby="titleHelp" placeholder="Title">
        </div>
        <div class="form-group">
            <label for="content" class="title_blog"><i class="fa-brands fa-microblog"></i> Content</label>
            <textarea name="content" class="form-control" id="content" rows="5" placeholder="Content">{{ old('content', $article->content) }}</textarea>
        </div>
        <button id="submit-btn-edit" type="submit" class="btn btn-outline-primary"><i class="fa-solid fa-floppy-disk"></i></button>
    </form>
</div>
<script>
    var editor1 = new RichTextEditor("#content");
</script>
@endsection