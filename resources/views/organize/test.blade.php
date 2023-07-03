@extends('article.Index')

@section('content-test')
<div> TEST </div>


<style>
    * {
        /* border: 1px solid pink; */
    }
</style>
<script>
    console.log('Ngay tại TEST');
</script>

@endsection

@section('content-vanmanh')
    <div id="vanmanh"> NGUYENVANMANH </div>
        @parent
    <div> PRO VIP </div>
@endsection

@push('styles-test')
    <link rel="stylesheet" href="{{ asset('css/article/styles-test.css') }}">
    {{-- <style>
        * {
            background-color: green;
        }
    </style> --}}
@endpush

@push('scripts-test')
    <script src="{{ asset('js/article/scripts-test.js') }}"></script>
    {{-- <script>
        console.log('Hello');
        var vanmanh = window.document.getElementById('vanmanh');
        vanmanh.onclick = function(){
            vanmanh.style.display = 'none';
        }
    </script> --}}
@endpush