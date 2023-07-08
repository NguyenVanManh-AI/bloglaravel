@extends('Blog.Layouts.Master')
@section('content')
{{-- LƯU Ý : File CSS phải để đầu , để vào là load css đầu tiên tránh vỡ giao diện do load html đầu tiên --}}
<link rel="stylesheet" href="{{asset('Blog/css/sidebar-dashboard.css')}}">

{{-- @include('Blog.Layouts.Sidebar') --}}
<div class="sidebar" style="opacity: 1;">
    <ul class="nav-links" id="accordion"> 
        {{-- id="accordion" là gom các collapse lại --}}
        <div id="logo">
            <img id="img_logo" src="{{asset('Blog/image/laravel.png')}}" alt="">
            <span id="text_logo" >Blog Laravel</span>
            <span id="show_sidebar" ><i class="bx bx-menu"></i></span>
        </div>
        <li>
            <div >
                {{-- Mỗi collapse sẽ có id tương ứng của nó data-target="#collapseUser" và  id="collapseUser"--}}
                <a style="font-weight: 500 !important;" href="#" class="link_arrow" data-toggle="collapse" data-target="#collapseUser" aria-expanded="true" aria-controls="collapseOne">
                    <i class="fa-solid fa-user-gear"></i>
                    <span class="link_name">Information Settings</span>
                    <i class="bx bxs-chevron-down arrow"></i>
                </a>
                {{-- id="accordion" , data-parent="#accordion" là gom các collapse lại --}}
                <div id="collapseUser" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body2 list_card">
                    <a href="#"><i class="fa-solid fa-address-card"></i><span class="link_name">Update Information</span></a>
                    <a href="#"><i class="fa-solid fa-key"></i><span class="link_name">Change Password</span></a>
                </div>
                </div>
            </div>
        </li>
        <li> {{-- link đa cấp --}}
            <div >
                {{-- Mỗi collapse sẽ có id tương ứng của nó data-target="#collapseArticle" và  id="collapseArticle"--}}
                <a href="#" class="link_arrow" data-toggle="collapse" data-target="#collapseArticle" aria-expanded="true" aria-controls="collapseOne">
                    <i class="fa-brands fa-blogger-b"></i><span class="link_name">Articles</span><i class="bx bxs-chevron-down arrow"></i>
                </a>
                {{-- id="accordion" , data-parent="#accordion" là gom các collapse lại --}}
                <div id="collapseArticle" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body2 list_card">
                        <a href="#"><i class="fa-solid fa-heart"></i><span class="link_name">My Article</span></a>
                        <a href="#"><i class="fa-solid fa-square-plus"></i><span class="link_name">Add Article</span></a>
                    </div>
                </div>
            </div>
        </li>
        <li><a href="#"><i class="fa-solid fa-circle-question"></i><span class="link_name">Help</span></a></li> {{-- link đơn --}}
        <li><a href="#"><i class="fa-solid fa-circle-info"></i><span class="link_name">Comment</span></a></li>  {{-- link đơn --}}
        <li>
            <div class="profile-details">
                <div class="name-job">
                    <div class="profile_name">Prem Shahi</div>
                    <div class="job">Web Desginer</div>
                </div>
                <a href="" id="logout"><i class="bx bx-log-out"></i></a>
            </div>
        </li>
    </ul>
</div>
<div class="home-main"> 
    @yield('view-content')
</div>
{{-- LƯU Ý : File JS phải để cuối để HTML CSS load hết đã rồi cuối cùng mới đến JS tránh client không hoạt động được --}}
<script src="{{asset('Blog/js/sidebar-dashboard.js')}}"></script>
@endsection
