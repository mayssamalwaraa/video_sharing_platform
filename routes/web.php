<?php

use App\Http\Controllers\LikeController;
use App\Http\Controllers\VideoContoller;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HistoryContoller;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('layouts.main');
    })->name('dashboard');
});
// Route::get('/videos/{id}',[VideoContoller::class,'show']);
Route::resource('/videos',VideoContoller::class)->middleware('auth');
Route::get('/video/search',[VideoContoller::class,'search'])->name('video.search');
Route::post('/like',[LikeController::class,'likeVideo'])->name('like');
Route::post('/view',[VideoContoller::class,'addView'])->name('view');

Route::post('/comment',[CommentController::class,'saveComment'])->name('comment');
Route::get('/comment/{id}/edit',[CommentController::class,'edit'])->name('comment.edit');
Route::patch('/comment/{id}',[CommentController::class,'update'])->name('comment.update');
Route::get('/comment/{id}',[CommentController::class,'destroy'])->name('comment.destroy');

Route::get('/history',[HistoryContoller::class,'index'])->name('history');


