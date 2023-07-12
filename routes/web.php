<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogAuthController;
use App\Http\Controllers\MainController;

// Blog 
// Auth 
Route::get('login', [BlogAuthController::class, 'login'])->name('login');
Route::get('register', [BlogAuthController::class, 'register'])->name('register');
Route::post('user-login', [BlogAuthController::class, 'userLogin'])->name('login.user'); 
Route::post('user-register', [BlogAuthController::class, 'userRegister'])->name('register.user'); 

// Forgot Password
Route::post('forgot-pw-sendcode', [BlogAuthController::class, 'forGotSend'])->name('forgot.sendcode'); 
Route::get('forgot-form', [BlogAuthController::class, 'forGotForm']);
Route::post('forgot-update', [BlogAuthController::class, 'forGotUpdate'])->name('forgot.update');


Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [BlogAuthController::class, 'dashboard']);
    Route::get('logout', [BlogAuthController::class, 'logout'])->name('logout');
});


// OAuth2 
Route::get('authorized/google', [BlogAuthController::class, 'redirectToGoogle'])->name('google');
Route::get('authorized/google/callback', [BlogAuthController::class, 'handleGoogleCallback']);

Route::get('authorized/github', [BlogAuthController::class, 'redirectToGithub'])->name('github');
Route::get('authorized/github/callback', [BlogAuthController::class, 'handleGithubCallback']);

// Route::get('authorized/twitter', [CustomAuthController::class, 'redirectToTwitter']);
// Route::get('authorized/twitter/callback', [CustomAuthController::class, 'handleTwitterCallback']);

// Blog 
Route::prefix('blog')->controller(BlogController::class)->name('blog.')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', 'dashboard');
        Route::get('/all', 'all')->name('all');

        Route::get('/add', 'showAdd')->name('add');
        Route::get('/detail/{id}', 'showDetail')->name('show');
        Route::get('/edit/{id}', 'showEdit')->name('show-edit');
        Route::get('/my', 'myArticle')->name('my');

        Route::post('/add', 'addArticle')->name('add');
        Route::post('/update', 'updateArticle')->name('update');
        Route::post('/delete/{id}', 'deleteArticle')->name('delete');
        Route::get('/ajax-search', 'ajaxSearch')->name('search');
        Route::get('/ajax-search-my', 'ajaxSearchMy')->name('search-my');
        Route::get('/test', 'test')->name('test');
        Route::get('/test222', 'test222')->name('test222');
    });
});

// Infor 
Route::prefix('infor')->controller(BlogAuthController::class)->name('infor.')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/view-infor', 'viewInfor')->name('view-infor');
        Route::post('/update-infor', 'updateInfor')->name('update-infor');
        Route::post('/change-password', 'changePassword')->name('change-password');
    });
});

// Main 
Route::prefix('main')->controller(MainController::class)->name('main.')->group(function () {
    Route::get('/view', 'viewMain')->name('view-main');
    Route::get('/ajax-update-comment', 'updateComment')->name('update-comment'); // ajax thì nên dùng GET thay vì dùng POST 
    Route::get('/ajax-delete-comment', 'deleteComment')->name('delete-comment'); 
    Route::get('/ajax-add-comment', 'addComment')->name('add-comment'); 
    Route::get('/personal-page/{id_user}', 'personalPage')->name('personal-page');
    Route::get('/article-details/{id_article}', 'articleDetails')->name('article-details');
    Route::get('/ajax-search-left', 'searchLeft')->name('search-left');
});

// giải thích : thực chất GET hay POST đều cũng chỉ là ta mượn một phương thức để lên được controller làm gì đó thôi 
// nên get hay post cũng không quan trọng lắm (nếu không tính đến chuyện bảo mật)







Route::prefix('article')->controller(ArticleController::class)->name('article.')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/', 'all');
        Route::get('/add', 'showAdd');
        Route::get('/detail/{id}', 'showDetail')->name('show');
        Route::get('/edit/{id}', 'showEdit')->name('show-edit');
        Route::get('/my', 'myArticle');

        Route::post('/add', 'addArticle')->name('add');
        Route::post('/update', 'updateArticle')->name('update');
        Route::post('/delete/{id}', 'deleteArticle')->name('delete');
        Route::get('/ajax-search', 'ajaxSearch')->name('search');
        Route::get('/ajax-search-my', 'ajaxSearchMy')->name('search-my');
        Route::get('/test', 'test')->name('test');
        Route::get('/test222', 'test222')->name('test222');
    });
});