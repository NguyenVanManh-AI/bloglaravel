@extends('Blog.Layouts.Master')
@section('content')
<div class="container-fluid ps-md-0">
    <div class="row g-0">
      <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
      <div class="col-md-8 col-lg-6">
        <div class="login d-flex align-items-center py-5">
          <div class="container">
            <div class="row">
              <div class="col-md-9 col-lg-8 mx-auto">
                <h3 class="login-heading mb-4">Welcome back!</h3>
                <!-- Sign In Form -->
              <form method="POST" action="{{ route('login.user')}}" enctype="multipart/form-data">
                @csrf 
                  <div class="form-floating mb-3">
                    <input name="email" value="{{ old('email') }}" type="text" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                    <label for="floatingInput">Email Or Username</label>
                  </div>
                  <div class="form-floating mb-3">
                    <input name="password" value="{{ old('password') }}" type="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                    <label for="floatingPassword">Password</label>
                  </div>
  
                  <div class="form-check mb-3 ml-1">
                    <input class="form-check-input" type="checkbox" value="" id="rememberPasswordCheck">
                    <label class="form-check-label" for="rememberPasswordCheck">
                      Remember password
                    </label>
                  </div>
  
                  <div class="d-grid">
                    <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit">Sign in</button>
                    <div class="text-center">
                      <a class="small" href="{{ route('register') }}">Do not have an account ? Sign up here.</a>
                    </div>
                    <div class="text-center">
                        <a class="small" href="#">Forgot password?</a>
                      </div>
                  </div>

                  <hr class="my-4">
  
                  {{-- <div class="d-grid mb-2">
                    <button class="btn btn-lg btn-google btn-login fw-bold text-uppercase" type="submit">
                      <i class="fab fa-google me-2"></i> Sign up with Google
                    </button>
                  </div>
    
                  <div class="d-grid">
                    <button class="btn btn-lg btn-facebook btn-login fw-bold text-uppercase" type="submit">
                        <i class="fa-brands fa-github"></i> Sign up with Github
                    </button>
                  </div> --}}

                <div class="social google">
                    <a href="{{ route('google') }}" >
                        <img src="{{asset('Blog/image/google.png')}}" alt=""> Sign up with Google
                    </a>
                </div>
    
                <div class="social github">
                    <a href="{{ route('github') }}" >
                        <img src="{{asset('Blog/image/github.png')}}" alt=""> Sign up with Github
                    </a>
                </div>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<style>
.login {
  min-height: 100vh;
}

.bg-image {
  background-image: url("{{asset('Blog/image/login.jfif')}}");
  background-size: cover;
  background-position: center;
}

.login-heading {
  font-weight: 300;
}

.btn-login {
  font-size: 0.9rem;
  letter-spacing: 0.05rem;
  padding: 0.75rem 1rem;
}

.btn-google {
  color: black !important;
  background-color: white;
}
.social {
    height: 40px;
    /* border: 1px solid gray; */
    border-radius: 5px;
    /* text-transform: uppercase; */
    display: flex;
    cursor: pointer;
    align-items: center;
    line-height: 40px;
    align-content: center;
    margin-bottom: 10px;
    justify-content: center;
}
.social a {
    display: flex;
    height: 100%;
    color: black;
    line-height: 100%;
    align-content: center;
    align-items: center;
    font-weight: 500;
    padding: 5px;
    color: white;
    width: 100%;
    justify-content: center;
}

.social a:hover {
    text-decoration: none;
}
.social img {
    height: 100%;
    padding: 2px;
    width: auto;
    border-radius: 40px;
    background-color: white;
    margin-right: 20px;
}
.social.google {
    background-color: #4284F3;
}
.social.github {
    background-color: black;
}
</style>
@endsection
