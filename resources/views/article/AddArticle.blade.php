@extends('dashboard')

@section('content')
<div class="col-6 mx-auto">
    <div class="alert alert-success text-center" role="alert">
        Add Article 
    </div>
    {{-- <form method="POST" action="/article/add"> nếu không đặt name cho route --}} 
    <form method="POST" action="{{ route('article.add') }}">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input value="{{ old('title') }}" name="title" type="text" class="form-control" id="title" aria-describedby="titleHelp" placeholder="Title">
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" class="form-control" id="content" rows="5" placeholder="Content">{{ old('content') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add</button>
    </form>
</div>
@endsection