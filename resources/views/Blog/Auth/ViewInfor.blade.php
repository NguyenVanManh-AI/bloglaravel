@extends('Blog.Layouts.ViewContent')
@section('content-blog')
<style>
    #title_update_infor {
        text-transform: uppercase;
        font-weight: 500;
        font-size: 20px;
        color: #0085FF;
    }
    label {
        color: #0085FF;
    }
    #big_update > img {
        position: absolute;
        right: 0px;
        top: 0px;
        opacity: 0.9;
        min-width: 100%;
        /* max-height: 120vh; */
        max-height: 100%;
        object-fit: cover;
        filter: blur(8px);
        -webkit-filter: blur(8px);
    }
    form {
        background-color: #000;
        box-shadow: rgb(204, 219, 232) 3px 3px 6px 0px inset, rgb(204, 219, 232) -3px -3px 6px 1px inset;
        padding: 30px 40px;
        border-radius: 10px;
        position: relative;
        background-color: white;
        background-color: rgba(255, 255, 255, 0.545);
        font-weight: bold;
    }
</style>
<div class="container_big" style="padding: 0px 30px">
    <div class="pt-3" id="big_update">
        @if(\Illuminate\Support\Str::startsWith($user->avatar, 'http'))
            <img src="{{ $user->avatar }}" >
        @else
            <img src="{{ 'http://localhost:8000/' . $user->avatar }}" >
        @endif
        <form method="POST" action="{{ route('infor.update-infor')}}" enctype="multipart/form-data">
        @csrf 
            <br>
            <p id="title_update_infor"><i class="fa-solid fa-circle-user"></i> Update Information</p>
            <div class="form-group row ml-2 mr-2">
                <div class="col-8">
                    <div class="row mb-3">
                        <label for="staticEmail" class="col-sm-3 col-form-label"><i class="fa-solid fa-signature mr-1"></i> Username</label>
                        <div class="col-sm-9">
                            <input value="{{ old('username', $user->username) }}" name="username" type="text" class="form-control" id="floatingInputUsername" placeholder="Username" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPassword" class="col-sm-3 col-form-label"><i class="fa-solid fa-user-check mr-1"></i> Full Name</label>
                        <div class="col-sm-9">
                            <input value="{{ old('name', $user->name) }}" name="name" type="text" class="form-control" id="floatingInputName" placeholder="Full Name" required autofocus>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="staticEmail" class="col-sm-3 col-form-label"><i class="fa-solid fa-envelope-circle-check mr-1"></i> Email</label>
                        <div class="col-sm-9">
                            <input hidden value="{{ old('email', $user->email) }}" name="email" type="email" class="form-control" id="floatingInputEmail" placeholder="email@example.com" required>
                            <input disabled value="{{ old('email', $user->email) }}" name="email" type="email" class="form-control" id="floatingInputEmail" placeholder="email@example.com" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="staticEmail" class="col-sm-3 col-form-label"><i class="fa-solid fa-venus-mars mr-1"></i> Gender</label>
                        <div class="col-sm-9">
                            <div class="form-check mb-2">
                                <input name="gender" class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="1" {{ old('gender', $user->gender) == 1 ? 'checked' : '' }} required>
                                <label class="form-check-label" for="gridRadios1"> Men </label>
                            </div>
                            <div class="form-check">
                                <input name="gender" class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" {{ old('gender', $user->gender) == 0 ? 'checked' : '' }} value="0" required>
                                <label class="form-check-label" for="gridRadios2"> Women </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4" id="upload_file_img">
                    <div id="dropbox">
                        <input type="file" name="avatar" id="image" accept="image/*">
                        <label for=""><i class="fa-solid fa-wand-magic-sparkles"></i> Avatar User</label>
                        <p>
                            @if(\Illuminate\Support\Str::startsWith($user->avatar, 'http'))
                                <img id="upload_img" src="{{ $user->avatar }}" >
                            @else
                                <img id="upload_img" src="{{ 'http://localhost:8000/' . $user->avatar }}" >
                            @endif
                            {{-- <img id="upload_img" src="{{ asset('Blog/image/icon/upload-file.png') }}" > --}}
                            {{-- Nhấp để chọn ảnh (jpg,jpeg,png) --}}
                        </p>
                    </div>
                    <div id="image-container">
                        <img id="image-preview" src="#" alt="Preview">
                        <img id="cancel-btn" src="{{ asset('Blog/image/icon/error.png') }}" >
                    </div>
                </div>
                <script>
                    // upload and preview image
                    function readURL(input) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                // $('#image-container').show();
                                $('#image-container').css('display', 'inline-block');
                                $('#image-preview').attr('src', e.target.result);
                                $('#image-preview').show();
                                $('#dropbox').hide();
                                $('#cancel-btn').show();
                            }
                            // check if image preview is hidden, then show it before reading new file
                            reader.readAsDataURL(input.files[0]);
                        }
                    }

                    $("#image").change(function() {
                        readURL(this);
                    });

                    $("#cancel-btn").click(function() {
                        $('#image-container').hide();
                        $('#image-preview').hide();
                        $('#dropbox').val('').show();
                        $('#cancel-btn').hide();
                        $('#image').val(''); // reset the input value to an empty string
                    });
                    // upload and preview image
                </script>
                <style>
                    #upload_img {
                        width: 100%;
                    }
                    #image-preview, #image-preview_imagesforever {
                        width: 100%;
                        height: auto;
                        display: none;
                    }
                    #cancel-btn, #cancel-btn_imagesforever {
                        position: absolute;
                        top: -5px;
                        right: -9px;
                        width: 20px;
                        display: none;
                        cursor: pointer;
                    }
                    #image-container, #image-container_imagesforever {
                        position: relative;
                        display: none;
                    }
                    #dropbox * , #dropbox_imagesforever *{
                        cursor: pointer;
                    }
                    #dropbox, #dropbox_imagesforever {
                        cursor: pointer;
                        width: 100%;
                        height: auto;
                        background: #f8f8f8;
                        border-radius:10px;
                        color: dimgray;
                        padding: 6px 6px; 
                        position: relative;
                        cursor: pointer;
                    }
                    #image, #image_imagesforever {
                        opacity: 0;
                        left: 0px; 
                        width: 100%;
                        height: 100%;
                        position: absolute;
                        cursor: pointer;
                    }
                    #dropbox:hover, #dropbox_imagesforever:hover {
                        background: #E8F5E9;
                    }
                    #dropbox p, #dropbox_imagesforever p {
                        text-align: center;
                        margin: 0px;
                        line-height: 100%;
                        align-content: center;
                        justify-content: center;
                        align-items: center;
                        display: flex;
                        color: #64bbf0;
                    }
                    #dropbox p i, #dropbox_imagesforever p i {
                        margin: 0px 10px;
                    }
                </style>
            </div>
            <div class="d-grid mb-2 mt-2">
                <div class="col-2 mx-auto">
                    <button class="col-12 mx-auto btn btn-outline-success text-uppercase" type="submit"><i class="fa-solid fa-floppy-disk mr-2"></i> SAVE</button>
                </div>
            </div>
        </form>
        <br>      
        <hr>
        <form method="POST" action="{{ route('infor.change-password')}}" enctype="multipart/form-data">
            @csrf 
            <p id="title_update_infor"><i class="fa-solid fa-bolt"></i> Change Password</p>
            <div class="col-7 mx-auto">
                @if(Auth::user()->password)
                <div class="row mb-2">
                    <label for="inputPassword" class="col-sm-5 col-form-label"><i class="fa-solid fa-key mr-1"></i></i>Old Password</label>
                    <div class="col-sm-7">
                        <input minlength="6" value="{{ old('name') }}" name="old_password" type="password" class="form-control" id="floatingInputName" placeholder="Old Password" required autofocus>
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="inputPassword" class="col-sm-5 col-form-label"><i class="fa-solid fa-key mr-1"></i></i>Confirm Old Password</label>
                    <div class="col-sm-7">
                        <input minlength="6" value="{{ old('name') }}" name="confirm_old_password" type="password" class="form-control" id="floatingInputName" placeholder="Confirm Old Password" required autofocus>
                    </div>
                </div>
                @endif
                <div class="row mb-2">
                    <label for="inputPassword" class="col-sm-5 col-form-label"><i class="fa-solid fa-key mr-1"></i></i>New Password</label>
                    <div class="col-sm-7">
                        <input minlength="6" value="{{ old('name') }}" name="new_password" type="password" class="form-control" id="floatingInputName" placeholder="New Password" required autofocus>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-2 mx-auto">
                    <button class="col-12 mx-auto btn btn-outline-success text-uppercase" type="submit"><i class="fa-solid fa-floppy-disk mr-2"></i> SAVE</button>
                </div>
            </div>
        </form>  
        <br>      
    </div>
</div>
@endsection
