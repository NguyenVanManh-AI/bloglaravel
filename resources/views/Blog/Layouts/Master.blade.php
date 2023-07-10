<!DOCTYPE html>
<html>
<head>

    <title>@yield('Title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- bootstrap 4 --}}
    <link rel="stylesheet" href="https://cdn.rawgit.com/tonystar/bootstrap-float-label/v4.0.2/bootstrap-float-label.min.css"/>
    
    {{-- https://github.com/tonycorporated/bootstrap-float-label --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    {{-- toastr --}}
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">

    <link rel="stylesheet" href="{{ asset('css/article/style.css') }}">
    <link rel="stylesheet" href="{{ asset('Blog/css/master.css') }}">

    {{-- icon --}}
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    
    @stack('styles-test')
    @stack('styles-test222')
    @stack('styles-index')

    {{-- bootstrap 5.0 --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> --}}

    {{-- bootstrap 4 --}}
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    {{-- RichTextEditor --}}
    <link rel="stylesheet" href="{{ asset('lib/richtexteditor/rte_theme_default.css') }} " />
    <script type="text/javascript" src="{{ asset('lib/richtexteditor/rte.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/richtexteditor/plugins/all_plugins.js') }}"></script>

</head>
<body>

    
    {{-- toastr --}}
    <script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script> 

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  --}}
    {!! Toastr::message() !!}
    {{-- @guest
    @else
    <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}">Logout</a>
    </li>
    @endguest --}}
    
    @yield('content')
    @stack('scripts-test')
    @stack('scripts-test222')
    @stack('scripts-index')
    {{-- bootstrap 5.0 --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> --}}

    
</body>
</html>