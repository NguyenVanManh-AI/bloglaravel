@extends('dashboard')

@section('content')
<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <h3 class="card-header text-center">Login</h3>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login.custom') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <input type="text" placeholder="Email" id="email" class="form-control" name="email" required
                                    autofocus>
                                @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <input type="password" placeholder="Password" id="password" class="form-control" name="password" required>
                                @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                            <div class="d-grid mx-auto">
                                <button type="submit" class="btn btn-dark btn-block">Signin</button>
                            </div>
                        </form>
                    </div>
                    <div style="display: flex;justify-content: center" class="flex items-center justify-end mt-2 mb-2">
                        <a href="{{ url('authorized/google') }}">
                            <img style="width: 200px" src="https://onymos.com/wp-content/uploads/2020/10/google-signin-button.png" style="margin-left: 3em;">
                        </a>
                    </div>
                    <div style="display: flex;justify-content: center" class="flex items-center justify-end mt-2 mb-4">
                        <a href="{{ url('authorized/github') }}">
                            <img style="width: 200px" src="https://help.dropsource.com/wp-content/uploads/sites/4/2017/02/gh-login-button.png" style="margin-left: 3em;">
                        </a>
                    </div>
                    {{-- <div style="display: flex;justify-content: center" class="flex items-center justify-end mt-2 mb-4">
                        <a href="{{ url('authorized/twitter') }}">
                            <img style="width: 200px" src="https://coderwall-assets-0.s3.amazonaws.com/uploads/picture/file/4347/twitter_button.png" style="margin-left: 3em;">
                        </a>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</main>
@endsection