<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestArticle;
use App\Models\Articles;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticlesController extends Controller
{
    public function all(Request $request){
        return view('article.Index');
    }

    public function showDetail(Request $request){
        return view('article.DetailArticle');
    }

    public function showAdd(Request $request){
        return view('article.AddArticle');
    }

    public function showEdit(Request $request){
        return view('article.EditArticle');
    }

    public function addArticle(RequestArticle $request){
        $request->validated();
        $data = $request->all();
        $user = Auth::user();
        $article = Articles::create([
            'id_user' => $user->id,
            'title' => $data['title'],
            'content' => $data['content'],
        ]);
        if ($article) {
            Toastr::success('Thêm bài viết thành công!');
            return redirect()->route('article.add'); // Thay 'articles.index' bằng tên route hiển thị danh sách bài viết
        } else {
            Toastr::error('Thêm bài viết thất bại!');
            return redirect()->back()->withInput(); // Quay trở lại trang trước đó và giữ lại dữ liệu đã nhập
        }
    }

    public function updateArticle(Request $request){
            
    }

    public function deleteArticle(Request $request){
            
    }

}
