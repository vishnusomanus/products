<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/home', [ProductController::class, 'index'])->name('home');
    Route::get('/dashboard', [ProductController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::post('/upload-image', [ProductController::class, 'uploadToGallery'])->name('upload.image');
});