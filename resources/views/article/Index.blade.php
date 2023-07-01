@extends('dashboard')

@section('content')
<div class="col-10 mx-auto">
    <div class="alert alert-success text-center" role="alert">
        All Article 
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
        <tbody>
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
    {{ $articles->links() }}
</div>
{{-- cách nào cũng được --}}
{{-- {{ $articles->links() }} --}}
{{-- {!! $articles->links() !!} --}}
@endsection