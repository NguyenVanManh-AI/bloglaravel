@extends('article.Index')

@section('content-test')
<div> TEST </div>
@endsection

@section('content-vanmanh')
    <div id="vanmanh"> NGUYENVANMANH </div>
        @parent
    <div> PRO VIP </div>
@endsection

@push('styles-test222')
    {{-- <link rel="stylesheet" href="{{ asset('css/article/styles-test.css') }}"> --}}
    <style>
        * {
            /* background-color: yellow; */
        }
    </style>
@endpush

@push('scripts-test222')
    {{-- <script src="{{ asset('js/article/scripts-test.js') }}"></script> --}}
    <script>
        console.log($.ajax());
        $.ajax({
            url: "{{ route('article.search-my') }}", // Cách 1 
            // url: "/article/ajax-search-my", // Cách 2
            type: "GET",
            data: {
                // _token: "{{ csrf_token() }}",
                search: ''
            },
            success: function(response) {
                // Cập nhật nội dung bảng dữ liệu
                console.log(response.render_html);
                // $('#body-article').html(response.render_html);
                // $('#pagination_container').html(response.pagination);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });

        console.log('Hello 2222');
        var vanmanh = window.document.getElementById('vanmanh');
        vanmanh.onclick = function(){
            vanmanh.style.color = 'blue';
        }
    </script>
@endpush