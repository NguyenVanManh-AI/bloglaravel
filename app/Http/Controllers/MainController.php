<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestCreateUser;
use App\Http\Requests\RequestUpdateInfor;
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use App\Models\Comment;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Mail;
use App\Mail\NotifyMail;
use App\Mail\ForgotPassword;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MainController extends Controller
{
    public function viewMain(Request $request){
        // $articles = Article::all();
        // foreach($articles as $key => $article){
        //     $num = count(Comment::where('id_article',$article->id)->get());
        //     $articles[$key]->num_comment = $num;
        // }     
        // $articles = Article::withCount('commentsCount')->paginate(6);
        // $articles = Article::join('users', 'users.id', '=', 'articles.id_user')
        //     ->select('articles.*', 'users.*', 'articles.id as id_article', 'users.id as id_user')
        //     ->withCount('commentsCount') // chú ý withCount phải bỏ sau select
        //     ->orderBy('articles.id','DESC')
        //     ->paginate(6);
        // // dd($articles);

        // foreach($articles as $key => $article){
        //     $comments = Comment::where('id_article',$article->id_article)
        //     ->join('users', 'users.id', '=', 'comments.id_user')
        //     ->select('comments.*', 'users.*', 'comments.id as id_comment', 'users.id as id_user')
        //     ->get();
        //     $articles[$key]->comments = $comments;
        //     // dd($comments);
        // }
        $articles = Article::join('users', 'users.id', '=', 'articles.id_user')
            ->select('articles.*', 'users.*', 'articles.id as id_article', 'users.id as id_user')
            ->withCount('commentsCount') // chú ý withCount phải bỏ sau select
            ->orderBy('articles.id','DESC')
            ->paginate(6);

        foreach ($articles as $article) {
            $comments = Comment::where('id_article', $article->id_article)
                ->join('users', 'users.id', '=', 'comments.id_user')
                ->select('comments.*', 'users.*', 'comments.id as id_comment', 'users.id as id_user')
                ->orderBy('comments.id','DESC')
                ->get();
            $article->comments = $comments;
        }
        return view('Blog.Main.Main',['articles'=>$articles]);
    }

    public function updateComment(Request $request){
        $comment = Comment::where('id',$request->id_comment)->first();
        $status = $comment->update(['content' => $request->new_content_comment]);
        return response()->json([
            'status' => $status
        ]);
    }

    public function deleteComment(Request $request){
        $comment = Comment::where('id',$request->id_comment)->first();
        $status = $comment->delete();
        return response()->json([
            'status' => $status
        ]);
    }

    public function addComment(Request $request)
    {
        $user = Auth::user();
        $id_article = $request->id_article;
        $comment = Comment::create([
            'id_user' => $user->id,
            'id_article' => $id_article,
            'content' => $request->new_content_comment,
        ]);
        $article = Article::where('id', $id_article)->first();
    
        $comment_element = '
            
    <div class="comment_article" id="comment_article_'.$comment->id.'">
        <div class="avatar_comment">';
        if (Str::startsWith($user->avatar, 'http')) {
            $comment_element .= '<img alt="Avatar" src="'.$user->avatar.'">';
        } else {
            $comment_element .= '<img alt="Avatar" src="http://localhost:8000/'.$user->avatar.'">';
        }
        $comment_element .= '
        </div>
        <div id="infor_comment_'.$comment->id.'" class="main_infor_comment">
            <div class="infor_comment">
                <div class="infor_left">';
        if ($comment->id_user == $article->id_user) {
            $comment_element .= '<p class="author" ><i class="fa-solid fa-at"></i> Author</p>';
        }
        $comment_element .= '
                    <p class="infor_fullname_comment" data-id_user="'.$comment->id_user.'" >'.$user->name.'</p>
                    <p id="comment_content_'.$comment->id.'" class="comment_content infor_created_comment">'.$comment->content.'</p>
                </div>
            </div>
            <div class="setting_cmt" >
                <button class="btn_setting_cmt" ><i class="fa-solid fa-ellipsis"></i></button>
                <div class="show_setting_cmt hidden" >
                    <li id="li_edit_'.$comment->id.'" class="li_edit li_edit_comment" ><span class="setting_icon"><i class="fa-solid fa-pen-to-square"></i></span> <span>Edit Comment</span></li>
                    <li class="li_delete" id="li_delete_'.$comment->id.'"><span class="setting_icon"><i class="fa-solid fa-trash"></i></span> <span>Delete Comment</span></li>
                </div>
            </div>
        </div>
        <div id="form_edit_'.$comment->id.'" class="infor_comment hidden">
            <div class="infor_left">';
        if ($comment->id_user == $article->id_user) {
            $comment_element .= '<p class="author" ><i class="fa-solid fa-at"></i> Author</p>';
        }
        $comment_element .= '
                <p class="infor_fullname_comment">'.$user->name.'</p>
                <textarea id="textarea_'.$comment->id.'" class="edit_content">'.$comment->content.'</textarea>
                <button class="btn_save" id="btn_save_'.$comment->id.'"><i class="fa-solid fa-check"></i> Save</button>
                <button class="btn_cancel" id="btn_cancel_'.$comment->id.'"><i class="fa-solid fa-xmark"></i> Cancel</button>
            </div>
        </div>
    </div>';
        
        return response()->json([
            'comment_element' => $comment_element
        ]);
    }
    
    public function searchLeft(Request $request){

        $search_user = null;
        $search_article = null;
        $search_text = $request->search_text;
        $search_user = User::where('name', 'like', '%' . $search_text . '%')->take(10)->get();
        // ->take(10) => lấy tối đa là 10 
        if(count($search_user) < 10){ // nếu ít hơn 10 dòng thì search tiếp vào article cho đủ 10 dòng 
            $search_article = Article::where('title', 'like', '%' . $search_text . '%')->take(10-count($search_user))->get();
        }
        $result_search = '';
        if($search_user || $search_article){
            $result_search .= '<div class="item_user_article">';
            if($search_user){
                foreach ($search_user as $user){
                    $result_search .= '<div class="item_user" data-id_user="'.$user->id.'">';
                        if(Str::startsWith($user->avatar, 'http')) {
                            $result_search .= '<img alt="Avatar" src="'.$user->avatar.'" >';
                        }
                        else {
                            $result_search .= '<img alt="Avatar" src="http://localhost:8000/' . $user->avatar .'" >';
                        }
                        $result_search .= '<span> ' . $user->name .'</span></div>';
                }
            }
            if($search_article){
                foreach ($search_article as $article){
                    $result_search .= '<div class="item_article" data-id_article="'.$article->id.'" >';
                    $result_search .= '<i class="fa-solid fa-blog" style="margin-right: 8px;"></i>'. $article->title.'</div>';
                }
            }
            $result_search .= '</div>';
        }
        if(count($search_user) == 0 && count($search_article) == 0){
            $result_search = '<div class="no_result"><i class="fa-solid fa-magnifying-glass"></i> No result</div>';
        }
        return response()->json([
            'result_search' => $result_search
        ]);
    }

    public function personalPage(Request $request,$id_user){
        $personal = User::where('id',$id_user)->first();
        
        $articles = Article::where('id_user',$personal->id)
        ->join('users', 'users.id', '=', 'articles.id_user')
        ->select('articles.*', 'users.*', 'articles.id as id_article', 'users.id as id_user')
        ->withCount('commentsCount') // chú ý withCount phải bỏ sau select
        ->orderBy('articles.id','DESC')
        ->paginate(6);
        foreach ($articles as $article) {
            $comments = Comment::where('id_article', $article->id_article)
                ->join('users', 'users.id', '=', 'comments.id_user')
                ->select('comments.*', 'users.*', 'comments.id as id_comment', 'users.id as id_user')
                ->orderBy('comments.id','DESC')
                ->get();
            $article->comments = $comments;
        }
        return view('Blog.Main.PersonalPage',['articles'=>$articles,'personal' => $personal]);
    }

    public function articleDetails(Request $request,$id_article){
        $articles = Article::where('articles.id',$id_article)
        ->join('users', 'users.id', '=', 'articles.id_user')
        ->select('articles.*', 'users.*', 'articles.id as id_article', 'users.id as id_user')
        ->withCount('commentsCount') // chú ý withCount phải bỏ sau select
        ->orderBy('articles.id','DESC')
        ->get();
        foreach ($articles as $article) {
            $comments = Comment::where('id_article', $article->id_article)
                ->join('users', 'users.id', '=', 'comments.id_user')
                ->select('comments.*', 'users.*', 'comments.id as id_comment', 'users.id as id_user')
                ->orderBy('comments.id','DESC')
                ->get();
            $article->comments = $comments;
        }
        return view('Blog.Main.ArticleDetails',['articles'=>$articles]);
    }

    

}
