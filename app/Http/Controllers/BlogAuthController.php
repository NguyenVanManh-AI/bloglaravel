<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestCreateUser;
use App\Http\Requests\RequestUpdateInfor;
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
use App\Mail\ForgotPassword;
use App\Models\PasswordReset;
use App\Rules\ReCaptcha;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogAuthController extends Controller
{

    public function dashboard()
    {
        if(Auth::check()) return view("Blog.Layouts.Master");
        return view('auth.login');
    } 

    public function login()
    {
        if(Auth::check()) return redirect("dashboard");
        return view('Blog.Auth.login');
    } 
    public function register()  
    {
        if(Auth::check()) return redirect("dashboard");
        return view('Blog.Auth.register');
    }

    public function logout() {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }

    public function userLogin(Request $request)
    {
        $data = $request->all();
        $emailOrUsername = $data['email'];
        // cho phép đăng nhập bằng Email hoặc Username 
        // Đây là login bằng email 
        if (strpos($emailOrUsername, '@') !== false) {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
                'g-recaptcha-response' => ['required', new ReCaptcha]
            ]);
            // $this->sendMail($user);
            $credentials = $request->only('email', 'password');
            // LƯU Ý : ĐỐI VỚI HÀM $credentials = $request->only('email', 'password'); 
            // thì chỉ được ghi cố định là ('email', 'password'); => không được ghi khác 
            // chính vì thế mà bên form html . Dù có thể là username hoặc email nhưng mà vẫn phải đặt 
            // name="email" để qua bên này lấy . 
            if (Auth::attempt($credentials)) { // trong này bao gồm cả hàm xác nhận đã login rồi (Auth::login($newUser)) 
                // (bao gồm thêm tất cả các hàm , check mật khẩu đúng hay không các kiểu nữa)
                Toastr::success('Login successful !');
                return redirect()->route('infor.view-infor');
            }
            Toastr::error('Login details are not valid !');
            return redirect()->back()->withInput();
        } 
        // Đây là login bằng Username 
        else {
            $user = User::where('username',$emailOrUsername)->first();
            if($user && (Hash::check($data['password'], $user->password))) {
                Auth::login($user); // xác nhận đã login 
                Toastr::success('Login successful !');
                return redirect()->route('infor.view-infor');
            }
            else {
                Toastr::error('Login details are not valid !');
                return redirect()->back()->withInput();
            }
        }
    }

    public function userRegister(RequestCreateUser $request)
    {  
        // Không cho phép username có kí tự @ . (Nhằm phân biệt với email khi login)
        if (strpos($request->username, '@') !== false) {
            Toastr::error('Username cannot contain the @ character !');
            return redirect()->back()->withInput();
        }

        // Sau khi pass qua request thì kiểm tra xem có user nào (khác email được cung cấp mà có username đó hay không)
        // có thì trả về false ngay lập tức  
        $user = User::where('email', '!=', $request->email)->where('username', $request->username)->first();
        if($user){
            Toastr::error('Username already exists !');
            return redirect()->back()->withInput();
        }
        // $data = $request->all(); // lấy toàn bộ form input được gửi lên 
        $findEmail = User::where('email', $request->email)->first();
        if($findEmail){
            if($findEmail['password']){
                Toastr::error('Account already exists !');
                // return redirect("register");
                return redirect()->back()->withInput();
            }
            else { // chưa có password mà có email thì là tài khoản của mạng xã hội (google,github,..) => cập nhật password 
                $avatar = $this->saveAvatar($request);
                $findEmail->update([
                    'password' => Hash::make($request['password']),
                    'avatar' => $avatar,
                    'name' => $request['name'],
                    'username' => $request['username'],
                    'gender' => $request['gender']
                ]);
            }
        }
        else {
            $data = $request->all();
            $avatar = $this->saveAvatar($request);
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'avatar' => $avatar,
                'username' => $request['username'],
                'gender' => $request['gender']
            ]);
            Toastr::success('Register successful !');
            $this->sendMail($user);
        }
        return redirect()->back();
        // return redirect("dashboard")->withSuccess('You have signed-in');
    }

    public function saveAvatar(Request $request){
        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            // $filename = time() . '.' . $image->getClientOriginalExtension();
            // $image->getClientOriginalName() = tên file (bao gồm cả tên file và phần mở rộng)
            // pathinfo($name, PATHINFO_FILENAME); => hàm để bỏ phần mở rộng đi chỉ lấy phần tên trước dấu chấm 
            $filename =  pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/Blog/image/avatars', $filename);
            return 'storage/Blog/image/avatars/' . $filename;
        }
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
                return redirect()->route('infor.view-infor');
            }else{// nếu chưa thì tạo account 
                $findEmail = User::where('email', $user->email)->first();
                if($findEmail){ // đã có trong hệ thống thì update id 
                    $findEmail->update(['google_id' => $user->id]);
                    Auth::login($findEmail); // xác nhận đã login 
                    Toastr::success('Login successful !');
                }
                else { // chưa có thì tạo tài khoản 
                    $newUser = User::create([
                        'name' => $user->name,
                        'email' => $user->email,
                        'google_id'=> $user->id,    
                        'username'=> 'user_' . $user->id,    
                        'avatar'=> $user->avatar,    
                        // 'password' => encrypt('123456vanmanh') // mật khẩu mặt định 
                    ]);
                    Auth::login($newUser); // xác nhận đã login 
                    Toastr::success('Register successful !');
                    $this->sendMail($newUser);
                }
                // return redirect()->route('infor.view-infor');
                return redirect()->route('infor.view-infor');
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
                return redirect()->route('infor.view-infor');
            }else{// nếu chưa thì tạo account 
                $findEmail = User::where('email', $user->email)->first();
                if($findEmail){ // đã có trong hệ thống thì update id 
                    $findEmail->update(['github_id' => $user->id]);
                    Auth::login($findEmail); // xác nhận đã login 
                    Toastr::success('Login successful !');
                }
                else { // chưa có thì tạo tài khoản 
                    $newUser = User::create([
                        'name' => $user->name,
                        'email' => $user->email,
                        'github_id'=> $user->id,   
                        'username'=> 'user_' . $user->id,    
                        'avatar'=> $user->avatar,     
                        // 'password' => encrypt('123456vanmanh') // mật khẩu mặt định 
                    ]);
                    Auth::login($newUser); // xác nhận đã login 
                    Toastr::success('Register successful !');
                    $this->sendMail($newUser);
                }
                return redirect()->route('infor.view-infor');
            }            
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    // Forgot password
    public function forGotSend(Request $request)
    {
        // Nếu không có cột id thì Không dùng first() hay firstOrFail 
        // hay firstOrCreate , updateOrCreate gì được hết . 
        // thêm vào thì dùng bình thường . 
        $token = Str::random(32);
        $email = $request->email;
        $user = PasswordReset::where('email', $email)->first();
        if($user) $user->update(['token' => $token]);
        else {
            PasswordReset::create([
                'email' => $email,
                'token' => $token
            ]);
        }
        $url = 'http://localhost:8000/forgot-form?token=' . $token;
        Mail::to($email)->send(new ForgotPassword($url));
        return redirect()->back();
    }

    public function forGotForm(Request $request){
        return view('Blog.Auth.reset-password');
    }

    public function forGotUpdate(Request $request){
        $token = $request->token;
        $new_password = Hash::make($request->new_password);
        $userReset = PasswordReset::where('token', $token)->first();
        if($userReset){
            if($request->new_password != $request->confim_new_password){
                Toastr::error('New password and confirm new password do not match !');
                return redirect()->back()->withInput();
            }
            $user = User::where('email',$userReset->email)->first();
            if($user){
                $user->update(['password' => $new_password]);
                Toastr::success('Reset Password successful !');
                $userReset->delete(); // reset rồi thì xóa trong table password_reset đi 
                return redirect('login');
            }
            Toastr::error('Can not find the account !'); // không tìm thấy tài khoản 
            return redirect('register');
        } 
        else {
            Toastr::error('Token has expired !');
            return redirect('register');
        }

    }
    public function getTitle($title_main,$title_sub){
        $title['title_main'] = $title_main;
        $title['title_sub'] = $title_sub;
        return $title;
    }
    public function viewInfor(){
        $user = Auth::user();
        return view('Blog.Auth.ViewInfor',['user' => $user, 'title' => $this->getTitle('Information Settings','Update Information')]);
    }

    public function updateInfor(RequestUpdateInfor $request){
        $user = User::find(Auth::user()->id);
        $avatar = null;
        if($request->avatar){
            $avatar = $this->saveAvatar($request);
            if(!Str::startsWith($user->avatar, 'http')){
                if($user->avatar) File::delete($user->avatar); 
            }
        }
        $status = $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'gender' => $request->gender,
            'avatar' => $avatar ?? $user->avatar // nếu $avatar null thì giữ nguyên 
        ]);
        if ($status) {
            // Session::flush();
            // Auth::logout();
            // Auth::login($user);
            // Ở đây không cần logout xong login lại hay gì cả . 
            // Update user này là nó tự update luôn cả thông tin đang đăng nhập 
            Toastr::success('Successfully updated !');
            return redirect()->route('infor.view-infor');
        } else {
            Toastr::error('Update failed !');
            return redirect()->back()->withInput(); 
        }
    }
    public function changePassword(Request $request){
        $user = User::find(Auth::id());
        if ($user->password == null) {
            $user->update(['password' => Hash::make($request['new_password'])]);
        } 
        else {
            if ($request->old_password != $request->confirm_old_password) {
                Toastr::error('Old password and confirm old password do not match !');
                return redirect()->back()->withInput();
            }
            if (!Hash::check($request->old_password, $user->password)) {
                Toastr::error('Old password is incorrect !');
                return redirect()->back()->withInput();
            }
            $user->update(['password' => Hash::make($request['new_password'])]);
        }
        Toastr::success('Updated password successfully !');
        return redirect()->route('infor.view-infor');
    }
}
