@extends('Blog.Layouts.Master')
@section('content')
<style>
    #big_main {
        display: flex;
        background-color: #F2F4F6;
        padding-top: 10px;
    }
    #left_main, #right_main {
        width: 25%;
        /* border: 1px solid blue; */
        height: 90vh;
    }
    #middle_main {
        width: 50%;
        height: calc(100vh - 10px);
        overflow: hidden;
        overflow-y: scroll;
        background-color: white;
    }
    #middle_main::-webkit-scrollbar {
        display: none;
    }
    /* Trong rich text editor có cái thanh nằm dọc mà cứ hiện bên lề trái rất khó chịu => ẩn nó đi  */
    rte-floatpanel {
        display: none !important;
    }
</style>
<div id="big_main">
    <div id="left_main" >
        @include('Blog.Main.Left')
    </div>
    <div id="middle_main">
    
    @include('Blog.Main.Middle')
    {{-- @yield('content-main') --}}
    
    </div>
    <div id="right_main" >
        @include('Blog.Main.Right')
    </div>
    <style>
        #toTop {
          /* display: none; */
          position: fixed !important;
          bottom: 30px !important;
        }
        /* .show {
          display: block;
        } */
        
      </style>
      <div id="toTop" v-if="showButton"><i class="fa-solid fa-chevron-up"></i></div>
      <script>
        $('.logo_blog').on('click', function() {
          window.location.href = "/main/view";
        }); 

        var btn = $('#button');

        // $(window).scroll(function() {
        //   if ($('#dashboard_user').scrollTop() > 300) {
        //     $('#toTop').addClass('show');
        //   } else {
        //     $('#toTop').removeClass('show');
        //   }
        // });

        $('#toTop').on('click', function(e) {
          e.preventDefault();
          $('html, body').animate({scrollTop:0}, '300');
          $('#dashboard_user').animate({scrollTop:0}, '300');
          $('.main_content').animate({scrollTop:0}, '300');
        });
      </script>
</div>
@endsection
