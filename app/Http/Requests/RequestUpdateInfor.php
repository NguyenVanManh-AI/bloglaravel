<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class RequestUpdateInfor extends FormRequest
{
    public function authorize()
    {
        return true; // true là cho tất cả vào . false là chỉ đăng nhập mới request này được . 
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'username' => 'required|unique:users,username,'.Auth::user()->id,
            'email' => 'required|email|unique:users,email,'.Auth::user()->id,
            'gender' => 'required',
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
