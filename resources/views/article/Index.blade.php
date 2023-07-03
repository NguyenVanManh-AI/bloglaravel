@extends('dashboard')

@section('content')
<div class="col-10 mx-auto">
    <div class="alert alert-success text-center" role="alert">
        All Article 
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
                <td>{{ $article->name }}</td>
                <td>
                    <a href="{{ route('article.show', ['id' => $article->id]) }}" class="btn btn-primary">
                        <i class="fa-solid fa-eye"></i> View
                    </a>
                </td>
                {{-- <td><button type="button" class="btn btn-primary"><i class="fa-solid fa-eye"></i> View</button></td> --}}
                <td>
                    @if($article->id_user == auth()->user()->id)
                    <a href="{{ route('article.show-edit', ['id' => $article->id]) }}" class="btn btn-primary">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </a>
                    @endif 
                </td>
                {{-- <td><button type="button" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i> Edit</button></td> --}}
                {{-- <td><button type="button" class="btn btn-danger"><i class="fa-solid fa-trash"></i> Delete</button></td> --}}
                <td>
                    {{-- $article->id là truyền vào route 1 giá trị , còn ['id' => $article->id] là truyền vào nhiều giá trị --}}
                    @if($article->id_user == auth()->user()->id)
                    <form method="POST" action="{{ route('article.delete', $article->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this article?');">
                        @csrf
                        <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i> Delete</button>
                    </form>
                    @endif 
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div id="pagination_container">
        {{ $articles->links() }}
    </div>
    @yield('content-test')
    @section('content-vanmanh')
        <h1>NAME</h1>
    @show



</div>
{{-- cách nào cũng được --}}
{{-- {{ $articles->links() }} --}}
{{-- {!! $articles->links() !!} --}}
<script src="{{ asset('js/article/search-all.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/article/all.css') }}">


{{-- <style>
    * {
        border: 1px solid pink;
    }
</style>
<script>
    console.log('Ngay tại Index');
</script> --}}




@endsection

@push('styles-index')
    {{-- <link rel="stylesheet" href="{{ asset('css/article/styles-test.css') }}"> --}}
    <style>
        /* * {
            border: 1px solid pink;
        } */
    </style>
@endpush

@push('scripts-index')
    {{-- <script src="{{ asset('js/article/scripts-test.js') }}"></script> --}}
    <script>
        console.log('Hello INDEX');
        // var vanmanh = window.document.getElementById('vanmanh');
        // vanmanh.onclick = function(){
        //     vanmanh.style.display = 'none';
        // }
    </script>
@endpush

