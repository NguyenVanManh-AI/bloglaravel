<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Mail;
use App\Mail\NotifyMail;

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


        $user = User::where('email', $request->email)->first();
        // $this->sendMail($user);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) { // trong này bao gồm cả hàm xác nhận đã login rồi (Auth::login($newUser))
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
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $findEmail = User::where('email', $request->email)->first();
        if($findEmail){
            if($findEmail['password']){
                Toastr::error('Tài khoản đã tồn tại');
                return redirect("register");
            }
            else { // chưa có password mà có email thì là tài khoản của mạng xã hội (google,github,..) => cập nhật password 
                $findEmail->update(['password' => Hash::make($request['password'])]);
            }
        }
        else {
            $data = $request->all();
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ]);
            Toastr::success('Đăng kí tài khoản thành công !');
            $this->sendMail($user);
        }
        return redirect("dashboard")->withSuccess('You have signed-in');
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


    // Login by Google 
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();
            if($finduser){ // nếu đã tồn tại thì cho vào dashboard 
                Auth::login($finduser);
                return redirect()->intended('dashboard');
            }else{// nếu chưa thì tạo account 
                $findEmail = User::where('email', $user->email)->first();
                if($findEmail){ // đã có trong hệ thống thì update id 
                    $findEmail->update(['google_id' => $user->id]);
                    Auth::login($findEmail); // xác nhận đã login 
                    Toastr::success('Đăng nhập thành công');
                }
                else { // chưa có thì tạo tài khoản 
                    $newUser = User::create([
                        'name' => $user->name,
                        'email' => $user->email,
                        'google_id'=> $user->id,    
                        // 'password' => encrypt('123456vanmanh') // mật khẩu mặt định 
                    ]);
                    Auth::login($newUser); // xác nhận đã login 
                    Toastr::success('Đăng kí thành công');
                    $this->sendMail($newUser);
                }
                return redirect()->intended('dashboard');
            }            
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    // send Mail 
    public function sendMail($user){
        Mail::to($user->email)->send(new NotifyMail($user->name));     
        if (Mail::failures()) {
            Toastr::error('Send Mail Error !');
            return response();
        }
        else{
            Toastr::success('Send Mail Success !');
            return response();
        }
    }

    // Login by Github 
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }
    public function handleGithubCallback()
    {
        try {
            $user = Socialite::driver('github')->user();
            $finduser = User::where('github_id', $user->id)->first();
            if($finduser){ // nếu đã tồn tại thì cho vào dashboard 
                Auth::login($finduser);
                return redirect()->intended('dashboard');
            }else{// nếu chưa thì tạo account 
                $findEmail = User::where('email', $user->email)->first();
                if($findEmail){ // đã có trong hệ thống thì update id 
                    $findEmail->update(['github_id' => $user->id]);
                    Auth::login($findEmail); // xác nhận đã login 
                    Toastr::success('Đăng nhập thành công');
                }
                else { // chưa có thì tạo tài khoản 
                    $newUser = User::create([
                        'name' => $user->name,
                        'email' => $user->email,
                        'github_id'=> $user->id,    
                        // 'password' => encrypt('123456vanmanh') // mật khẩu mặt định 
                    ]);
                    Auth::login($newUser); // xác nhận đã login 
                    Toastr::success('Đăng kí thành công');
                    $this->sendMail($newUser);
                }
                return redirect()->intended('dashboard');
            }            
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    // Login by Twitter 
    // public function redirectToTwitter()
    // {
    //     return Socialite::driver('twitter')->redirect();
    // }
    // public function handleTwitterCallback()
    // {
    //     try {
    //         $user = Socialite::driver('twitter')->user();
    //         dd($user);
                
    //     } catch (Exception $e) {
    //         dd($e->getMessage());
    //     }
    // }
}
// ================================================================
/*
    login bằng google 
        + nếu google_id này đã có trong db => cho login vào  
        + nếu google_id này chưa có trong db 
            + nếu email này chưa có trong db => tạo tài khoản mới (password để trống)
            + nếu email này đã có trong db => chỉ cần bổ sung thêm google id 
    
    login bằng github
        + nếu github_id này đã có trong db => cho login vào  
        + nếu github_id này chưa có trong db 
            + nếu email này chưa có trong db => tạo tài khoản mới (password để trống)
            + nếu email này đã có trong db => chỉ cần bổ sung thêm github id 

    user register 
        + mail đã tồn tại 
            + có password => không cho đăng kí nữa 
            + không có password => đây là tài khoản đăng nhập trước đó bằng mạng xã hội (google hoặc github,...) 
                => lấy password người dùng nhập bổ sung vào  
        + mail chưa tồn tại => đăng kí như bình thường 

VỀ CỞ BẢN HOÀN TOÀN GIỐNG NHAU , KHÔNG ĐỔI GÌ CẢ , COPY ra và thay vào thôi . 
CODE CỦA GITHUB hoàn toàn giống GOOLE => Áp dụng cho các mạng xã hội khác 

+ Về xử lý maill unique => tưởng phức tạp , tưởng thêm một mạng xã hội thì lại phải xem lại cách xử lý sao maill 
    thì phải unique còn password khi đăng kí thì phải điền vào còn khi đăng nhập bằng mạng xã hội thì không điền 
    => thì mấy cái này do mình code ok nên khi thêm một mạng xã hội mới ví dụ github thì chỉ cần cop ra paste vào thôi 
*/
