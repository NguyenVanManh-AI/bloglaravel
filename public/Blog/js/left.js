// search user and article 
$(document).ready(function() {
    // Thêm sự kiện 'input' bằng jQuery và xử lý sự kiện
    $('#text_search').on('input', function() {
        var search_text = $(this).val();
        if(search_text != '') {
            $('#list_search').removeClass('hidden');
            $.ajax({
                url: '/main/ajax-search-left',
                type: 'GET',
                data: {
                    search_text:search_text,
                },
                success: function(response) {
                    $('#inner_search').html(response.result_search);
                    console.log(response.result_search);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
        else $('#list_search').addClass('hidden');
    });
});


// goto Main 
$('body').on('click', '.logo_blog', function (event) {
    window.location.href = "/main/view";
}); 

// goto personalPage
$('body').on('click', '.item_user', function (event) {
    idUser = $(this).data('id_user');
    window.location.href = "/main/personal-page/"+idUser;
}); 

// goto Article Details 
$('body').on('click', '.item_article', function (event) {
    idArticle = $(this).data('id_article');
    window.location.href = "/main/article-details/"+idArticle;
}); 
