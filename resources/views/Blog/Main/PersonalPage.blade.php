@extends('Blog.Layouts.Master')
@section('content')
<link rel="stylesheet" href="{{asset('Blog/css/personal-page.css')}}">
<div id="big_infor">
    <div id="header_infor" class="sticky" style="background-color: white;">
      <div id="top_infor">
        <div id="thumbnail"> 
            @if(\Illuminate\Support\Str::startsWith($personal->avatar, 'http'))
                <img id="upload_img" src="{{ $personal->avatar }}" >
            @else
                <img id="upload_img" src="{{ 'http://localhost:8000/' . $personal->avatar }}" >
            @endif
        </div>
      </div>
      <div id="bottom_infor">
        <div id="avatar_infor">
            @if(\Illuminate\Support\Str::startsWith($personal->avatar, 'http'))
                <img id="upload_img" src="{{ $personal->avatar }}" >
            @else
                <img id="upload_img" src="{{ 'http://localhost:8000/' . $personal->avatar }}" >
            @endif
        </div>
        <div id="full_infor_user">
          <div>
            <div style="font-weight: bold;font-size: 26px;">
              {{ $personal->name }}  <i class="fa-solid fa-circle-check" style="color: #0076e5;"></i>
            </div>
            <div style="font-size: 20px;color: #0076e5;">
              {{ $articles->total() }} Articles <i class="fa-solid fa-blog"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="body_infor" class="d-flex">
      <div class="col-2" style="background-color: #F2F4F6;"></div>
      <div class="col-3 pt-2" id="left_body" style="height: 100vh;background-color: #F2F4F6;">
        <div id="infor_details">
          <h1 style="font-weight: bold;font-size: 18px;margin-bottom: 20px;word-spacing: 2px;font;text-transform: uppercase;color: #0076e5;"><i class="fa-solid fa-address-card"></i> Introduce yourself</h1>
          <li><span class="icon"><i class="fa-solid fa-signature"></i></span> <span class="name">{{ $personal->name }}</span></li>
          {{-- <li><span class="icon"><i class="fa-solid fa-calendar-check"></i></span> <span class="name">Date of birth {{ process_date(full_user.date_of_birth) }}</span></li> --}}
          <li><span class="icon"><i class="fa-solid fa-venus-mars"></i></span> 
            @if($personal->gender == 1)
            <span class="name">Men</span> 
            @else 
            <span class="name">Women</span> 
            @endif 
          </li>
          <li><span class="icon"><i class="fa-solid fa-blog"></i></span> <span class="name">{{ $articles->total() }} Articles</span></li>
          <h1 style="font-weight: bold;font-size: 18px;margin-bottom: 20px;margin-top: 30px;word-spacing: 2px;font;text-transform: uppercase;color: #0076e5;"><i class="fa-solid fa-phone"></i> Contact Info</h1>
          <li style="color: #0076e5;"><a href="mailto:{{$personal->email}}"><span class="icon"><i class="fa-solid fa-envelope"></i></span> <span class="name">{{ $personal->name }}</span></a></li>
        </div>
      </div>
      <div class="col-5 pr-0 pl-0 mt-2">
        <style>
            .footer_comment_article {
                padding: 10px 25% !important;
            }
        </style>
        @include('Blog.Main.PersonalMiddle')

    </div>
      {{-- <div class="col-2" style="background-color: #F2F4F6;"></div> --}}
      <style>
        .logo_blog {
          width: 50px;
          height: 50px;
          cursor: pointer;
          position: fixed !important;
          bottom: 30px !important;
        }
        .logo_blog img{
          width: 100%;
          object-fit: cover;
        }

        #toTop {
          /* display: none; */
          position: fixed !important;
          bottom: 30px !important;
        }
        /* .show {
          display: block;
        } */
        
      </style>
      <div class="logo_blog" ><img src="{{asset('Blog/image/logo.png')}}"/></div>
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
  </div>
@endsection
