<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/',[PostController::class,'index'])->name('posts.index');

Route::get('/post/show{id}',[PostController::class,'show'])->name('posts.show');

Route::get('/post/edit/{id}',[PostController::class,'edit'])->name('posts.edit');
Route::put('/post/update/{id}',[PostController::class,'update'])->name('posts.update');

Route::get('/delete/{id}',[PostController::class,'delete'])->name('posts.delete');


Route::get('/post/new_post',[PostController::class,'new_post'])->name('new_post');

Route::post('/post/store',[PostController::class,'store'])->name('create');

Route::get('/viewer',[PostController::class,'viewer'])->name('show.index');
