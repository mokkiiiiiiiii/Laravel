<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('', function () {
    return redirect()->route('login');
});

Route::get('index', [PostsController::class, 'index'])->name('posts.index');

Route::get('/create-form', [PostsController::class, 'createForm'])->name('posts.createForm');

Route::post('/post/create', [PostsController::class, 'create'])->name('posts.create');

Route::get('post/{id}/update-form', [PostsController::class, 'updateForm'])->name('posts.edit');

Route::post('/post/update', [PostsController::class, 'update']);

Route::get('post/{id}/delete', [PostsController::class, 'delete']);

Route::get('/posts/search', [PostsController::class, 'search'])->name('posts.search');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');  // ログインページにリダイレクト
})->name('logout');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
