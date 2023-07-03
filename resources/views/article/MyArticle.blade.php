@extends('dashboard')

@section('content')
<div class="col-10 mx-auto">
    <div class="alert alert-success text-center" role="alert">
        My Article 
    </div>
    <div class="form-group row">
        <label for="staticEmail" class="col-sm-1 col-form-label">Search</label>
        {{-- <div class="col-sm-11"><input value="" name="title" type="text" class="form-control" id="search" aria-describedby="titleHelp" placeholder="Search"></div> --}}
        <div class="col-sm-11">
            <input value="" name="title" type="text" class="form-control" id="search" aria-describedby="titleHelp" placeholder="Search">
        </div>
    </div>
    <table class="table">
        <thead class="thead-light">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Content</th>
            <th scope="col">Author</th>
            <th scope="col" colspan="3">Features</th>
          </tr>
        </thead>
        <tbody id="body-article">
            @foreach ($articles as $index => $article)
            <tr>
                <td>{{ $articles->perPage()*($articles->currentPage() -1) + $index + 1 }}</td>
                <td>{{ $article->title }}</td>
                <td>{{ $article->content }}</td>
                <td>{{ $article->content }}</td>
                <td>
                    <a href="{{ route('article.show', ['id' => $article->id]) }}" class="btn btn-primary">
                        <i class="fa-solid fa-eye"></i> View
                    </a>
                </td>
                <td>
                    <a href="{{ route('article.show-edit', ['id' => $article->id]) }}" class="btn btn-primary">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </a>
                </td>
                <td>
                    <form method="POST" action="{{ route('article.delete', $article->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this article?');">
                        @csrf
                        <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i> Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div id="pagination_container">
        {{ $articles->links() }}
    </div>
</div>
{{-- cách nào cũng được --}}
{{-- {{ $articles->links() }} --}}
{{-- {!! $articles->links() !!} --}}
<script src="{{ asset('js/article/search-my.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/article/my.css') }}">
@endsection