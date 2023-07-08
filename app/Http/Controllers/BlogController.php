<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RequestArticle;
use App\Models\Article;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function dashboard(Request $request){
        return view('Blog.Layouts.Dashboard');
    }

    public function all(Request $request){
        return view('Blog.Content.All');
    }
}
