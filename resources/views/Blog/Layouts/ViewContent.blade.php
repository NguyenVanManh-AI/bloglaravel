@extends('Blog.Layouts.Dashboard')
@section('view-content')
<style>
    #view-content {
        width: 100%;
        height: 100%;
        padding: 10px 30px
    }
    #view-content-min {
        border-radius: 10px;
        min-height: 96%;
        padding-bottom: 1px;
        box-shadow: rgba(136, 165, 191, 0.48) 6px 2px 16px 0px, rgba(255, 255, 255, 0.8) -6px -2px 16px 0px;
    }
    #content-main {
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
        padding: 10px;
        padding-top: 20px;
        margin: 10px;
        min-height: 82vh;
        box-shadow: rgb(204, 219, 232) 3px 3px 6px 0px inset, 
            rgba(255, 255, 255, 0.5) -3px -3px 6px 1px inset,
            rgba(204, 219, 232, 0.5) -3px 3px 6px 1px inset,
            rgba(204, 219, 232, 0.5) 3px -3px 6px 1px inset;
        /* box-shadow: rgb(204, 219, 232) 3px 3px 6px 0px inset, rgba(255, 255, 255, 0.5) -3px -3px 6px 1px inset; */
    }
    #header-main {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        /* border: 3px solid rgb(228, 228, 228); */
        background-color: #0085FF;
        height: 60px;
        display: flex;
        align-content: center;
        align-items: center;
        padding: 0px 30px;
        margin-bottom: 10px;
        color: white;
        font-weight: bold;
    }
    #title_main, #title_sub {
        letter-spacing: 6px;
        border-top:2px solid white; 
    }
    #title_article {
        letter-spacing: 2px;
        border-top:2px solid white; 
    }
    #title_sub {
        margin-left: 5px;
    }

    #header-main .fa-angles-right {
        margin: 0px 10px;
    }

    /* Style Header */
    .style_a {
        overflow: hidden;
        position: relative;
        display: inline-block;
        cursor: pointer;
    }
    .style_a::before,
    .style_a::after {
        content: '';
        position: absolute;
        width: 100%;
        left: 0;
    }
    .style_a::before {
        background-color: white;
        height: 2px;
        bottom: 0;
        transform-origin: 100% 50%;
        transform: scaleX(0);
        transition: transform .3s cubic-bezier(0.76, 0, 0.24, 1);
    }
    .style_a::after {
        content: attr(data-replace);
        height: 100%;
        bottom: 2px;
        transform-origin: 100% 50%;
        transform: translate3d(200%, 0, 0);
        transition: transform .3s cubic-bezier(0.76, 0, 0.24, 1);
        color: white;
    }
    .style_a:hover::before {
        transform-origin: 0% 50%;
        transform: scaleX(1);
    }
    .style_a:hover::after {
        transform: translate3d(0, 0, 0);
    }
    .style_a span {
        display: inline-block;
        transition: transform .3s cubic-bezier(0.76, 0, 0.24, 1);
    }
    .style_a:hover span {
        transform: translate3d(-200%, 0, 0);
    }
    .style_a {
        text-decoration: none;
        color: #18272F;
        font-weight: 700;
        vertical-align: top;
    }
    /* Style Header */

</style>
<div id="view-content" >
    <div id="view-content-min">
        <div id="header-main" >
            {{-- @dd($title) --}}
            <a class="style_a" data-replace="{{$title['title_main']}}" id="title_main"><span>{{$title['title_main']}}</span></a> 
            <i class="fa-solid fa-angles-right"></i>
            <a class="style_a" data-replace="{{$title['title_sub']}}" id="title_sub"><span>{{$title['title_sub']}}</span></a> 

            {{-- @if(Route::has('blog.show')) là kiểm tra trong file web.php có tồn tại route này không --}}
            @if(request()->routeIs('blog.show') || request()->routeIs('blog.show-edit')) {{-- request()->routeIs('blog.show') là kiểm tra trang hiện tại có phải route này hay không --}}
            <i class="fa-solid fa-angles-right"></i>
            <a class="style_a" data-replace="{{\Illuminate\Support\Str::limit($article->title, 59, '...')}}" id="title_article"><span>{{\Illuminate\Support\Str::limit($article->title, 59, '...')}}</span></a> 
            @endif
            @if(request()->routeIs('infor.view-infor')) 
            <i class="fa-solid fa-angles-right"></i>
            <a class="style_a" data-replace="{{\Illuminate\Support\Str::limit(auth()->user()->name, 59, '...')}}" ><span>{{\Illuminate\Support\Str::limit(auth()->user()->name, 59, '...')}}</span></a> 
            @endif
        </div>
        <div id="content-main">
            @yield('content-blog')
        </div>
    </div>
    <br>
</div>
@endsection
