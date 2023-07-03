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
Route::post('user-registration', [BlogAuthController::class, 'userRegister'])->name('register.user'); 
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

// Article  
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