<?php

use App\Http\Controllers\EmailController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [PostController::class, 'index']);
Route::get('/create', [PostController::class, 'create']);
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/posts/{post}', [PostController::class, 'show']);
Route::get('/posts/{post}/comment', [\App\Http\Controllers\CommentController::class, 'index']);
Route::get('/posts/{posts}/comments/{comment}', [\App\Http\Controllers\CommentController::class, 'show']);


Route::get('/api', [EmailController::class, 'ApiFood']);
Route::get('/upload', [EmailController::class, 'showForm']);
Route::post('/upload-emails', [EmailController::class, 'uploadEmails'])->name('emails.upload');
