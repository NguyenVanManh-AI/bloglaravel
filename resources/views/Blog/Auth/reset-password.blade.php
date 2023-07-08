@extends('Blog.Layouts.Master')
@section('content')
    <div class="container">
      <div class="row">
        <div class="mt-5 col-lg-10 col-xl-9 mx-auto">
          <div class="card flex-row my-5 border-0 shadow rounded-3 overflow-hidden">
            <div class="card-img-left d-none d-md-flex">
              <!-- Background image for card set in CSS! -->
            </div>
            <div class="card-body pt-4 pb-4 pl-5 pr-5">
              <h5 class="card-title text-center mb-4 fw-light fs-5">Reset Password</h5>
              <form method="POST" action="{{ route('forgot.update')}}" enctype="multipart/form-data">
                {{-- upload file thì nhớ thêm enctype="multipart/form-data" --}}
                @csrf 
                {{-- lấy token cho vào input để gửi lên --}}
                <input hidden value="{{ old('token') }}" name="token" type="text" class="form-control" id="token" placeholder="Token">
                <div class="form-floating mb-3 has-float-label">
                  <input minlength="6" value="{{ old('new_password') }}" name="new_password" type="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                  <label for="floatingPassword">New Password</label>
                </div>
                <div class="form-floating mb-3 has-float-label">
                  <input minlength="6" value="{{ old('confim_new_password') }}" name="confim_new_password" type="password" class="form-control" id="floatingPasswordConfirm" placeholder="Confirm Password" required>
                  <label for="floatingPasswordConfirm">Confirm New Password</label>
                </div>
                <div class="d-grid mb-2">
                  <button class="col-12 btn btn-lg btn-primary btn-login fw-bold text-uppercase" type="submit">Submit</button>
                </div>
                <a class="d-block text-center mt-2 small" href="{{ route('login') }}">Have an account? Sign In</a>
              </form>
              {{-- Get token form Url --}}
              <script>
                url_string = window.location.href;
                var url = new URL(url_string);
                var token = url.searchParams.get("token");
                var inputToken = window.document.getElementById('token');
                inputToken.value = token;
              </script>

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