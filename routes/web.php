<?php

use App\Http\Controllers\AdminsController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\VideoContoller;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HistoryContoller;
use App\Http\Controllers\MainContoller;
use App\Http\Controllers\NotificationController;
use App\Models\Notification;
use Illuminate\Support\Facades\Route;



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
Route::get('/',[MainContoller::class,'index'])->name('main');
Route::get('/main/{channel}/videos',[MainContoller::class,'channelVideos'])->name('main.channels.videos');

Route::resource('/videos',VideoContoller::class)->middleware('auth');
Route::get('/video/search',[VideoContoller::class,'search'])->name('video.search');
Route::post('/like',[LikeController::class,'likeVideo'])->name('like');
Route::post('/view',[VideoContoller::class,'addView'])->name('view');

Route::post('/comment',[CommentController::class,'saveComment'])->name('comment');
Route::get('/comment/{id}/edit',[CommentController::class,'edit'])->name('comment.edit');
Route::patch('/comment/{id}',[CommentController::class,'update'])->name('comment.update');
Route::get('/comment/{id}',[CommentController::class,'destroy'])->name('comment.destroy');

Route::get('/history',[HistoryContoller::class,'index'])->name('history');
Route::delete('/history/{id}',[HistoryContoller::class,'destroy'])->name('history.destroy');
Route::delete('/destroyAll',[HistoryContoller::class,'destroyAll'])->name('history.destroyAll');

Route::get('/channel',[ChannelController::class,'index'])->name('channel.index');
Route::get('/channel/search',[ChannelController::class,'search'])->name('channel.search');
Route::post('/notification',[NotificationController::class,'index'])->name('notification')->middleware('auth');
Route::prefix('/admin')->middleware('can:update-videos')->group(function(){
    Route::get('/',[AdminsController::class,'index'])->name('admin.index');
    Route::get('/channels',[ChannelController::class,'adminIndex'])->name('channels.index');
    Route::patch('/{user}/channels',[ChannelController::class,'adminUpdate'])->name('channels.update')->middleware('can:update-users');
    Route::delete('/channels/{user}',[ChannelController::class,'adminDestroy'])->name('channels.delete')->middleware('can:update-users');
    Route::patch('/{user}/block',[ChannelController::class,'adminBlock'])->name('channels.block')->middleware('can:update-users');
    Route::get('/channels/blocked',[ChannelController::class,'blockedChannels'])->name('channels.blocked')->middleware('can:update-users');
    Route::patch('/{user}/open',[ChannelController::class,'openBlock'])->name('channels.open.block')->middleware('can:update-users');
    Route::get('/allChannels',[ChannelController::class,'allChannels'])->name('channels.all')->middleware('can:update-users');
    Route::get('/mostViewedVideos',[ChannelController::class,'mostViewedVideos'])->name('most.viewed.videos')->middleware('can:update-users');









});

