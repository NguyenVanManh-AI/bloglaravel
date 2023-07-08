@extends('Blog.Layouts.Dashboard')
@section('view-content')
<div id="view-content" style="width: 100%;height: 100%;">
    <div id="header-main" style="border: 1px solid red;height: 60px;">
        ALL Article
    </div>
    <div id="content-main">
        @yield('content-blog')
    </div>
</div>
@endsection
