<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RequestArticle;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function getTitle($title_main,$title_sub){
        $title['title_main'] = $title_main;
        $title['title_sub'] = $title_sub;
        return $title;
    }

    public function all(Request $request){
        $articles = Article::join('users', 'articles.id_user', '=', 'users.id')
        ->select('articles.*', 'users.name') // nếu không có as thì mặc định nó sẽ là name 
        // ->select('articles.*', 'users.name as author') // đặt lại name cho nó  
        // ->select('articles.*', 'users.id') // giả sử muốn lấy ra id của users thì phải đặt lại name cho nó 
        // vì cả article và users đều có id 
        ->orderBy('articles.id', 'desc') // Sắp xếp giảm dần theo article.id (mới nhất lên đầu)
        ->paginate(6);
        return view('Blog.Article.Index',['articles' => $articles,'title'=> $this->getTitle('Articles','All Articles')]);
    }

    public function showDetail(Request $request,$id){
        $article = Article::find($id);
        return view('Blog.Article.DetailArticle',['article' => $article,'title'=> $this->getTitle('Articles','Details Articles')]);
    }

    public function showAdd(Request $request){
        return view('Blog.Article.AddArticle',['title'=> $this->getTitle('Articles','Add Articles')]);
    }

    public function showEdit(Request $request,$id){
        $article = Article::find($id);
        return view('Blog.Article.EditArticle',['article' => $article,'title'=> $this->getTitle('Articles','Update Articles')]);
    }

    public function myArticle(Request $request){
        $user = Auth::user();
        $articles = Article::where('id_user', $user->id)
        ->orderBy('id', 'desc')->paginate(6);
        return view('Blog.Article.MyArticle',['articles' => $articles,'title'=> $this->getTitle('Articles','My Articles')]);
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
            return redirect()->back(); // Thay 'articles.index' bằng tên route hiển thị danh sách bài viết
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
            // Xóa comment của bài viết đó 
            $comments = Comment::where('id_article', $article->id)->get();
            foreach ($comments as $comment) {
                $comment->delete();
            }
            // Xóa bài viết
            $article->delete();
            Toastr::success('Xóa bài viết thành công !');
            return redirect()->back();
        } else {
            Toastr::error('Bạn không có quyền xóa bài viết !');
            return redirect()->back();
        }
    }

    // ajax search 
    public function ajaxSearch(Request $request)
    {
        $articles = Article::join('users', 'articles.id_user', '=', 'users.id')
            ->select('articles.*', 'users.name')
            ->where('articles.title', 'like', '%' . $request->search . '%')
            ->orWhere('articles.content', 'like', '%' . $request->search . '%')
            ->orderBy('articles.id', 'desc')
            ->paginate(6);
        $render_html = '';
        foreach ($articles as $index => $article) {
            $render_html .= '<tr>
                <td>' . ($articles->perPage() * ($articles->currentPage() - 1) + $index + 1) . '</td>
                <td>' . Str::limit($article->title, 69, '...') . '</td>
                <td>' . $article->name . '</td>
                <td>
                    <a href="' . route('blog.show', ['id' => $article->id]) . '" class="btn btn-outline-primary">
                        <i class="fa-solid fa-eye"></i> View
                    </a>
                </td>
                <td>';
            if ($article->id_user == auth()->user()->id) {
                $render_html .= '<a href="' . route('blog.show-edit', ['id' => $article->id]) . '" class="btn btn-outline-primary">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </a>';
            }
            $render_html .= '</td>
                <td>';
            if ($article->id_user == auth()->user()->id) {
                $render_html .= '<form method="POST" action="' . route('blog.delete', $article->id) . '" onsubmit="return confirm(\'Are you sure you want to delete this article?\');">
                        ' . csrf_field() . '
                        <button type="submit" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i> Delete</button>
                    </form>';
            }
            $render_html .= '</td>
            </tr>';
        }
        $pagination = $articles->links()->toHtml();
        return response()->json([
            'render_html' => $render_html,
            'pagination' => $pagination,
        ]);
    }

    public function ajaxSearchMy(Request $request)
    {
        $user = Auth::user();
        $articles = Article::where('id_user', $user->id)
        ->where(function ($query) use ($request) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('content', 'like', '%' . $request->search . '%');
        })
        ->orderBy('id', 'desc')
        ->paginate(6);
    
        $render_html = '';
        foreach ($articles as $index => $article) {
            $render_html .= '<tr>
                <td>' . ($articles->perPage() * ($articles->currentPage() - 1) + $index + 1) . '</td>
                <td>' . Str::limit($article->title, 69, '...') . '</td>
                <td>
                    <a href="' . route('blog.show', ['id' => $article->id]) . '" class="btn btn-outline-primary">
                        <i class="fa-solid fa-eye"></i> View
                    </a>
                </td>
                <td>';
                $render_html .= '<a href="' . route('blog.show-edit', ['id' => $article->id]) . '" class="btn btn-outline-primary">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </a>';
            $render_html .= '</td>
                <td>';
                $render_html .= '<form method="POST" action="' . route('blog.delete', $article->id) . '" onsubmit="return confirm(\'Are you sure you want to delete this article?\');">
                        ' . csrf_field() . '
                        <button type="submit" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i> Delete</button>
                    </form>';
            $render_html .= '</td>
            </tr>';
        }
        $pagination = $articles->links()->toHtml();
        return response()->json([
            'render_html' => $render_html,
            'pagination' => $pagination,
        ]);
    }

    public function test(Request $request){
        $articles = Article::join('users', 'articles.id_user', '=', 'users.id')
        ->select('articles.*', 'users.name')
        ->orderBy('articles.id', 'desc')
        ->paginate(2);
        return view('organize.test',['articles' => $articles]);
        // return view('organize.test');
    }

    public function test222(Request $request){
        $articles = Article::join('users', 'articles.id_user', '=', 'users.id')
        ->select('articles.*', 'users.name')
        ->orderBy('articles.id', 'desc')
        ->paginate(2);
        return view('organize.test222',['articles' => $articles]);
        // return view('organize.test222');
    }

}
