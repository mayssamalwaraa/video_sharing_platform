<?php

use App\Http\Controllers\VideoContoller;
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
Route::resource('/videos',VideoContoller::class);
Route::get('/video/search',[VideoContoller::class,'search'])->name('video.search');
