<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Brian2694\Toastr\Facades\Toastr;

class RequestCreateUser extends FormRequest
{
    public function authorize()
    {
        return true; // true là cho tất cả vào . false là chỉ đăng nhập mới request này được . 
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'confirm-password' => 'required|same:password',
            'gender' => 'required',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function withValidator($validator)
    {
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Toastr::error($error);
            }
        }
    }
}
