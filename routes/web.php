<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect(route('home'));
});

Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::resource('admin/posts', App\Http\Controllers\Admin\PostController::class)->except('show');
    Route::get('admin/comments', [App\Http\Controllers\Admin\CommentController::class, 'index'])->name('comments.index');
    Route::delete('admin/comments/{comment}', [App\Http\Controllers\Admin\CommentController::class, 'destroy'])->name('comments.destroy');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/posts/{post}', [App\Http\Controllers\HomeController::class, 'showPost'])->name('posts.show');
Route::post('/posts/{post}/comment', [App\Http\Controllers\HomeController::class, 'storeComment'])->name('comments.store');
