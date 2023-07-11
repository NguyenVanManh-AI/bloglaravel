// show setting article 
$(document).ready(function() {
    $(document).on("click", function(event) {
      var target = $(event.target);
      if (!target.closest(".btn_setting").length && !target.closest(".show_setting").length) {
        $(".show_setting").addClass("hidden");
      }
    });
    $(".btn_setting").on("click", function() {
      var $showSetting = $(this).next(".show_setting");
      $showSetting.toggleClass("hidden");
      $(".btn_setting").not(this).next(".show_setting").addClass("hidden");
    });
});

// show setting comment  
$(document).ready(function() {
    $(document).on("click", function(event) {
      var target = $(event.target);
      if (!target.closest(".btn_setting_cmt").length && !target.closest(".show_setting_cmt").length) {
        $(".show_setting_cmt").addClass("hidden");
      }
    });
});
$('body').on('click', '.btn_setting_cmt', function (e) {
    var $showSetting = $(this).next(".show_setting_cmt");
    $showSetting.toggleClass("hidden");
    $(".btn_setting_cmt").not(this).next(".show_setting_cmt").addClass("hidden");
});

// ẩn hiện form edit comment 
$('body').on('click', '.li_edit_comment', function (e) {
    var str = $(this).attr('id');
    var parts = str.split('_');
    var id_comment = parts[2];
    $('#infor_comment_'+id_comment+', #form_edit_'+id_comment).toggleClass('hidden');
});

// cancel edit 
$('body').on('click', '.btn_cancel', function (e) {
    var str = $(this).attr('id');
    var parts = str.split('_');
    var id_comment = parts[2];
    $('#infor_comment_'+id_comment+', #form_edit_'+id_comment).toggleClass('hidden');
});

// btn save 
$('body').on('click', '.btn_save', function (e) {
    var str = $(this).attr('id');
    var parts = str.split('_');
    var id_comment = parts[2];
    var new_content_comment = $('#textarea_'+id_comment).val();
    $.ajax({
        url: '/main/ajax-update-comment',
        type: 'GET',
        data: {
          id_comment: id_comment,
          new_content_comment: new_content_comment
        },
        success: function(response) {
          // Xử lý kết quả thành công
          console.log(response);
        },
        error: function(xhr) {
          // Xử lý lỗi
          console.log(xhr.responseText);
        }
    });
    $('#comment_content_'+id_comment).html(new_content_comment);
    $('#infor_comment_'+id_comment+', #form_edit_'+id_comment).toggleClass('hidden');
});

// ajax thì nên dùng GET thay vì dùng POST 
// giải thích : thực chất GET hay POST đều cũng chỉ là ta mượn một phương thức để lên được controller làm gì đó thôi 
// nên get hay post cũng không quan trọng lắm (nếu không tính đến chuyện bảo mật)

// delete 
$('body').on('click', '.li_delete', function (e) {
    var str = $(this).attr('id');
    var parts = str.split('_');
    var id_comment = parts[2];
    $.ajax({
        url: '/main/ajax-delete-comment',
        type: 'GET',
        data: {
          id_comment: id_comment
        },
        success: function(response) {
          // Xử lý kết quả thành công
          console.log(response);
        },
        error: function(xhr) {
          // Xử lý lỗi
          console.log(xhr.responseText);
        }
    });
    $('#comment_article_'+id_comment).addClass('hidden');
});

// add Comment

// ajax load content article and comment 
// Ta có : <div class="ajax_load_article" data-id_article="{{$article->id_article}}"

var id_article = '';
$('.ajax_load_article').on('click', function() {
    id_article = $(this).data('id_article');
}); 

$('body').on('keydown', '.inlineFormInputGroup', function (event) {
    if (event.which == 13) { // Kiểm tra mã phím là Enter (mã 13)
        event.preventDefault(); // Ngăn chặn hành vi mặc định của phím Enter
        var new_content_comment = $(this).val();
        // console.log(new_content_comment);
        // console.log(id_article); 
        if(new_content_comment != ''){
            $.ajax({
                url: '/main/ajax-add-comment',
                type: 'GET',
                data: {
                    id_article:id_article,
                    new_content_comment: new_content_comment
                },
                success: function(response) {
                    $("#list_comment_"+id_article).append(response.comment_element);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
        $(this).val('');
    }
});


// ================================================================
// Fix lỗi không bắt được sự kiện đối với những element được add vào bằng append 
//     + https://stackoverflow.com/questions/52099861/event-listener-for-appended-html-elements-not-working
//     + Cùng 1 class những những element được load ngay khi tải trang thì bắt sự kiện bình thường 
//     + Còn những element được thêm vào sau bằng append thì không bắt sự kiện được 
//     + Cách fix là bọc đoạn code trong : 
//         $('body').on('click', '.announcement-delete-button', function (e) { /*Your code here*/ });

//     + Ví dụ : 
//         $(".btn_setting").on("click", function() {
//             var $showSetting = $(this).next(".show_setting");
//             $showSetting.toggleClass("hidden");
//             $(".btn_setting").not(this).next(".show_setting").addClass("hidden");
//         });

//     => Sẽ trở thành : 
//         $('body').on('click', '.btn_setting', function (e) {
//             var $showSetting = $(this).next(".show_setting");
//             $showSetting.toggleClass("hidden");
//             $(".btn_setting").not(this).next(".show_setting").addClass("hidden");
//         });

// ================================================================
