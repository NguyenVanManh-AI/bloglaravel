<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;

class CustomAuthController extends Controller
{

    public function index()
    {
        # Nếu mà đã đã đăng nhập thì không vào được trang login nữa . 
        # Ta cũng có một cách khác đó là đăng kí middleware cho nó  
        if(Auth::check()){
            return redirect("dashboard");
        }
        return view('auth.login');
    }  
      
    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            Toastr::success('Đăng nhập thành công');
            return redirect()->intended('dashboard')
                        ->withSuccess('Signed in');
        }
        return redirect("login")->withSuccess('Login details are not valid');
    }

    public function registration()  
    {
        # Nếu mà đã đã đăng nhập thì không vào được trang register nữa . 
        # Ta cũng có một cách khác đó là đăng kí middleware cho nó  
        if(Auth::check()){
            return redirect("dashboard");
        }
        return view('auth.registration');
    }
      
    public function customRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        $check = $this->create($data);
         
        return redirect("dashboard")->withSuccess('You have signed-in');
    }

    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }    
    
    public function dashboard()
    {
        if(Auth::check()){
            return view('dashboard');
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }
    
    public function signOut() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }
}