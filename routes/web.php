<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogAuthController;

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