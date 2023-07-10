/*
LƯU Ý : 
    + Khi bỏ đoạn code vào trực tiếp trong file C:\Users\ADMIN\Downloads\ProLaravel\bloglaravel\resources\views\dashboard.blade.php
        thì có thể để url theo name , tức là : url: "{{ route('article.search') }}"
    + Nhưng khi để file riêng ra thì hình như nó không hoạt động như thế , nên ta phải dùng url cụ thể cho nó . 
        là thế này : url: "article/ajax-search",
    + Chú ý phải là /article/ajax-search chứ không được article/ajax-search
    nếu article/ajax-search => thì nó sẽ tự động cộng thêm url hiện tại trên trang web nữa . 
*/
$(document).ready(function() {
    // Thêm sự kiện 'input' bằng jQuery và xử lý sự kiện
    $('#search').on('input', function() {
        var search = $(this).val();
        $.ajax({
            // url: "{{ route('article.search') }}", // Cách 1 
            url: "/blog/ajax-search", // Cách 2
            type: "GET",
            data: {
                // _token: "{{ csrf_token() }}",
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

        // Cách 1 
        // var url = "{{ route('article.search') }}";
        // var params = $.param({ page: page });
        // url += "?" + params;

        // Cách 2 
        var url = '/blog/ajax-search?page='+page

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