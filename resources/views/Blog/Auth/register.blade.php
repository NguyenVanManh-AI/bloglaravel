@extends('Blog.Layouts.Master')
@section('content')
<style>
  /* fix box-show che label của librayry has-float-label */
  .form-control:focus {
    box-shadow: none; 
  }
</style>
    <div class="container">
      <div class="row">
        <div class="col-lg-10 col-xl-9 mx-auto">
          <div class="card flex-row my-5 border-0 shadow rounded-3 overflow-hidden">
            <div class="card-img-left d-none d-md-flex">
              <!-- Background image for card set in CSS! -->
            </div>
            <div class="card-body pt-4 pb-4 pl-5 pr-5">
              <h5 class="card-title text-center mb-4 fw-light fs-5">Register</h5>
              <form method="POST" action="{{ route('register.user')}}" enctype="multipart/form-data">
                {{-- upload file thì nhớ thêm enctype="multipart/form-data" --}}
                @csrf 
                {{-- nhớ tất cả các form đều phải thêm @csrf --}}
                <div class="form-floating mb-3 has-float-label">
                    <input value="{{ old('name') }}" name="name" type="text" class="form-control" id="floatingInputName" placeholder="Full Name" required autofocus>
                    <label for="floatingInputName">Name</label>
                </div>

                <div class="form-floating mb-3 has-float-label">
                  <input value="{{ old('username') }}" name="username" type="text" class="form-control" id="floatingInputUsername" placeholder="Username" required>
                  <label for="floatingInputUsername">Username</label>
                </div>
  
                <div class="form-floating mb-3 has-float-label">
                  <input value="{{ old('email') }}" name="email" type="email" class="form-control" id="floatingInputEmail" placeholder="email@example.com" required>
                  <label for="floatingInputEmail">Email address</label>
                </div>
  
                {{-- <hr> --}}
  
                <div class="form-floating mb-3 has-float-label">
                  <input value="{{ old('password') }}" name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                  <label for="floatingPassword">Password</label>
                </div>
  
                <div class="form-floating mb-3 has-float-label">
                  <input value="{{ old('confirm-password') }}" name="confirm-password" type="password" class="form-control" id="floatingPasswordConfirm" placeholder="Confirm Password" required>
                  <label for="floatingPasswordConfirm">Confirm Password</label>
                </div>
  
                <div class="col-sm-12 border pt-2 mb-3">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-check">
                                <input name="gender" class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="1" checked required>
                                <label class="form-check-label" for="gridRadios1"> Men </label>
                            </div>
                            <div class="form-check">
                                <input name="gender" class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="0" required>
                                <label class="form-check-label" for="gridRadios2"> Women </label>
                            </div>
                        </div>
                        <div class="col-8 pb-2 d-flex justify-content-end" >
                            <div id="dropbox">
                              <input type="file" name="avatar" id="image" accept="image/*" required>
                                <p>
                                  <img id="upload_img" src="{{ asset('Blog/image/icon/upload-file.png') }}" >
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
                            .thumbimg {
                                border: 1px solid #ddd;
                                border-radius: 4px;
                                padding: 5px;
                                width: 130px;
                                transition: 0.2s;
                            }
                            #image-preview, #image-preview_imagesforever {
                                /* width: 112px; */
                                height: 64px;
                                /* padding: 5px; */
                                border: 1px dotted #b3b3b39e;
                                border-radius: 2px;
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
                                /* display: inline-block; */
                                display: none;
                                /* padding: 5px; */
                            }
                            #dropbox * , #dropbox_imagesforever *{
                                cursor: pointer;
                            }
                            #dropbox, #dropbox_imagesforever {
                                cursor: pointer;
                                /* margin: auto; */
                                /* width: 100%; */
                                background: #f8f8f8;
                                border-radius:10px;
                                color: dimgray;
                                padding: 5px 5px; /* ///+++ */
                                /* min-height: 120px; */
                                position: relative;
                                cursor: pointer;
                            }
                            #image, #image_imagesforever {
                                opacity: 0;/* invisible but it's there! */
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
                                padding: 5px 0;
                                /* height: 120px; */
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
                </div>
                <div class="d-grid mb-2">
                  <button class="col-12 btn btn-lg btn-primary btn-login fw-bold text-uppercase" type="submit">Register</button>
                </div>
                <a class="d-block text-center mt-2 small" href="{{ route('login') }}">Have an account? Sign In</a>
              </form>
              <hr class="my-4">
              <div class="d-flex justify-content-center">
                <a href="{{ route('main.view-main') }}" style="border-radius: 10px" type="button" class="btn btn-outline-primary"><i class="fa-solid fa-house"></i> Home</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

<style>
body {
  background: #007bff;
  background: linear-gradient(to right, #0062E6, #33AEFF);
}

.card-img-left {
  width: 45%;
  /* Link to your background image using in the property below! */
  background: scroll center url("{{asset('Blog/image/register.jfif')}}");
  background-size: cover;
}

.btn-login {
  font-size: 0.9rem;
  letter-spacing: 0.05rem;
  padding: 0.75rem 1rem;
}
</style>
@endsection