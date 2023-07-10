@extends('Blog.Layouts.ViewContent')
@section('content-blog')
<style>
    .title_blog {
        text-transform: uppercase;
        font-size: 20px;
        font-weight: bold;
        color: rgb(107, 107, 107);
    }
</style>
<br>
<div class="col-12 mx-auto">
    {{-- <form method="POST" action="/article/add"> nếu không đặt name cho route --}} 
    <form method="POST" action="{{ route('blog.add') }}">
        @csrf
        <div class="form-group">
            <label for="title" class="title_blog"><i class="fa-solid fa-blog"></i> Title</label>
            <input value="{{ old('title') }}" name="title" type="text" class="form-control" id="title" aria-describedby="titleHelp" placeholder="TITLE">
        </div>
        <div class="form-group">
            <label for="content" class="title_blog"><i class="fa-brands fa-microblog"></i> Content</label>
            <textarea name="content" class="form-control" id="content" rows="5" placeholder="Content">{{ old('content') }}</textarea>
        </div>
        <br>
        <div class="col-12 d-flex justify-content-center">
            <button type="submit" class="btn btn-outline-primary"><i class="fa-regular fa-paper-plane"></i> Add</button>
        </div>
    </form>
</div>
<script>
    var editor1 = new RichTextEditor("#content");
    // console.log(editor1.getHTMLCode());
    // $('#btn').on('click',function(){
    //     console.log(editor1.getHTMLCode());
    // });
</script>

@endsection