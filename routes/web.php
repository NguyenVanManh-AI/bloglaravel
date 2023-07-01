<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;

// Auth 
Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom'); 
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom'); 
Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [CustomAuthController::class, 'dashboard']);
    Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');
});

// OAuth2 
Route::get('authorized/google', [CustomAuthController::class, 'redirectToGoogle']);
Route::get('authorized/google/callback', [CustomAuthController::class, 'handleGoogleCallback']);

Route::get('authorized/github', [CustomAuthController::class, 'redirectToGithub']);
Route::get('authorized/github/callback', [CustomAuthController::class, 'handleGithubCallback']);

// Route::get('authorized/twitter', [CustomAuthController::class, 'redirectToTwitter']);
// Route::get('authorized/twitter/callback', [CustomAuthController::class, 'handleTwitterCallback']);

// Article  
Route::prefix('article')->controller(ArticleController::class)->name('article.')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/', 'all');
        Route::get('/add', 'showAdd');
        Route::get('/detail/{id}', 'showDetail');
        Route::get('/edit/{id}', 'showEdit')->name('show-edit');
        Route::get('/my', 'myArticle');

        Route::post('/add', 'addArticle')->name('add');
        Route::post('/update', 'updateArticle')->name('update');
        Route::post('/delete', 'deleteArticle');
    });
});