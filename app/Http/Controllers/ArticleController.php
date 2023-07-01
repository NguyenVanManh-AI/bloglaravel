<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestArticle;
use App\Models\Article;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function all(Request $request){
        $articles = Article::join('users', 'articles.id_user', '=', 'users.id')
        ->select('articles.*', 'users.name') // nếu không có as thì mặc định nó sẽ là name 
        // ->select('articles.*', 'users.name as author') // đặt lại name cho nó  
        // ->select('articles.*', 'users.id') // giả sử muốn lấy ra id của users thì phải đặt lại name cho nó 
        // vì cả article và users đều có id 
        ->orderBy('articles.id', 'desc') // Sắp xếp giảm dần theo article.id (mới nhất lên đầu)
        ->paginate(3);
        return view('article.Index',['articles' => $articles]);
    }

    public function showDetail(Request $request,$id){
        $article = Article::find($id);
        return view('article.DetailArticle',['article' => $article]);
    }

    public function showAdd(Request $request){
        return view('article.AddArticle');
    }

    public function showEdit(Request $request,$id){
        $article = Article::find($id);
        return view('article.EditArticle',['article' => $article]);
    }

    public function myArticle(Request $request){
        $user = Auth::user();
        $articles = Article::where('id_user', $user->id)->paginate(2);
        return view('article.MyArticle',['articles' => $articles]);
    }

    public function addArticle(RequestArticle $request){
        $request->validated();
        $data = $request->all();
        $user = Auth::user();
        $article = Article::create([
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

    public function updateArticle(RequestArticle $request){
        $request->validated();
        $data = $request->all();
        $user = Auth::user();
        // $article = Article::where('id',$request->id)->first();
        $article = Article::findOrFail($request->id); // tìm không thấy bài viết thì về lại 
        if($user->id != $article->id_user){ // input bị hidden đi rồi nhưng đề phòng client hack 
            // => đôi id bài viết => lên lại server thì query ra nếu khác thì không cho đổi 
            Toastr::error('Bạn không có quyền chỉnh sửa bài viết này !');
            return redirect()->back()->withInput();
        }
        $status = $article->update([
            'title' => $data['title'],
            'content' => $data['content'],
        ]);
        if ($status) {
            Toastr::success('Cập nhật bài viết bài viết thành công!');
            return redirect()->back()->withInput(); // Thay 'articles.index' bằng tên route hiển thị danh sách bài viết
        } else {
            Toastr::error('Cập nhật bài viết bài viết thất bại!');
            return redirect()->back()->withInput(); // Quay trở lại trang trước đó và giữ lại dữ liệu đã nhập
        }
    }

    public function deleteArticle(Request $request, $id)
    {
        // Kiểm tra xem người dùng có quyền xóa bài viết hay không
        // Ví dụ: Chỉ cho phép người tạo bài viết hoặc người có quyền quản trị xóa
        $article = Article::findOrFail($id); // tìm không thấy bài viết thì về lại 
        $user = Auth::user();
        $article = Article::where('id',$request->id)->first();
        if($user->id == $article->id_user){
        // if ($request->user()->can('delete', $article)) {
            // Xóa bài viết
            $article->delete();
            Toastr::success('Xóa bài viết thành công !');
            return redirect()->back();
        } else {
            Toastr::error('Bạn không có quyền xóa bài viết !');
            return redirect()->back();
        }
    }

}
