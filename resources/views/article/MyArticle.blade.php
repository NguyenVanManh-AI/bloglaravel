@extends('dashboard')

@section('content')
<div class="col-6 mx-auto">
    <div class="alert alert-success text-center" role="alert">
        My Article 
    </div>
    <table class="table">
        <thead class="thead-light">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Content</th>
            <th scope="col">Author</th>
            <th scope="col" colspan="2">Features</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($articles as $index => $article)
            <tr>
                <td>{{ $articles->perPage()*($articles->currentPage() -1) + $index + 1 }}</td>
                <td>{{ $article->title }}</td>
                <td>{{ $article->content }}</td>
                <td>{{ $article->content }}</td>
                <td>
                    <a href="{{ route('article.show-edit', ['id' => $article->id]) }}" class="btn btn-primary">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </a>
                </td>
                <td><button type="button" class="btn btn-danger"><i class="fa-solid fa-trash"></i> Delete</button></td>
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