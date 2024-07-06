<?php

use App\Http\Controllers\BlogPostController;
use Illuminate\Support\Facades\Route;

//first route
Route::get('/', [BlogPostController::class, 'index']);

//blogs route
Route::resource('blog', BlogPostController::class);

//likes on blog
Route::post('blog/{blogPost}/like', [BlogPostController::class, 'like'])->name('blog.like');

Auth::routes();
