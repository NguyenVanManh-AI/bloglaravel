<!DOCTYPE html>
<html>
<head>
    <title>Laravel 8 Custom Login And Registration Example - NiceSnippets.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css"> 

    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> --}}
    
    <link rel="stylesheet" href="{{ asset('css/article/style.css') }}">
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

</head>
<body>
    <script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {!! Toastr::message() !!}
    <nav class="navbar navbar-light navbar-expand-lg mb-5" style="background-color: #e3f2fd;">
        <div class="container">
            <a class="navbar-brand mr-auto" href="#">NiceSnippets</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register-user') }}">Register</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('signout') }}">Logout</a>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    @yield('content')


    {{-- BỎ MẤY LINK NÀY ĐI , NẾU KHÔNG SẼ LỖI jax Error: $.ajax Not Found --}}
    {{-- <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> --}}
    {{-- BỎ MẤY LINK NÀY ĐI , NẾU KHÔNG SẼ LỖI jax Error: $.ajax Not Found --}}

<script>
$(document).ready(function() {
    // Thêm sự kiện 'input' bằng jQuery và xử lý sự kiện
    $('#search').on('input', function() {
        var search = $(this).val();
        $.ajax({
            url: "{{ route('article.search') }}",
            type: "GET",
            data: {
                _token: "{{ csrf_token() }}",
                search: search
            },
            success: function(response) {
                // Cập nhật nội dung bảng dữ liệu
                $('#body-article').html(response.render_html);
                $('#pagination_container').html(response.pagination);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });

    // Bắt sự kiện khi người dùng nhấp vào phân trang
    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        // Lấy số trang được chọn
        var page = $(this).attr('href').split('page=')[1];
        // Lấy giá trị từ ô nhập liệu
        var search = $('#search').val();
        // Thực hiện yêu cầu AJAX để tìm kiếm và cập nhật kết quả trên trang web

        // Ở đây có thể dùng url dạng này : url: 'ajax-search-book?page=' + page, hoặc dạng như dưới đều được 
        var url = "{{ route('article.search') }}";
        var params = $.param({ page: page });
        url += "?" + params;

        $.ajax({
            url: url,
            method: 'GET',
            data: {
                search: search
            },
            success: function(response) {
                $('#body-article').html(response.render_html);
                $('#pagination_container').html(response.pagination);
            }
        });
    });
});
</script>

</body>
</html>