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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Check State In Home Page Route
Route::get('/check', [App\Http\Controllers\WelcomeController::class, 'check'])->name('check');
//Check State In Home Page Route End


Route::middleware(['checkProfileState'])->group(function () {
//Form Routes
    Route::get('/forma', [App\Http\Controllers\FormaController::class, 'index'])->name('forma');
    Route::put('/formpost', [App\Http\Controllers\FormaController::class, 'store'])->name('formpost');
    Route::get('/forma-all', [App\Http\Controllers\FormaController::class, 'showAll'])->name('forma-all');
    Route::get('/form-edit/{id}', [App\Http\Controllers\FormaController::class, 'formEdit'])->name('form-edit.{id}');
    Route::put('/form-edit-post/{id}', [App\Http\Controllers\FormaController::class, 'formEditPost'])->name('form-edit-post.{id}');
    Route::get('/form-delete/{id}', [App\Http\Controllers\FormaController::class, 'formDelete'])->name('form-delete.{id}');
    Route::get('/download-guarantee/{id}', [App\Http\Controllers\FormaController::class, 'guaranteeDownload'])->name('download-guarantee.{id}');
    Route::get('/leave-comment/{id}', [App\Http\Controllers\FormaController::class, 'leaveComment'])->name('leave-comment.{id}');
    Route::put('/leave-comment-post/{id}', [App\Http\Controllers\FormaController::class, 'leaveCommentPost'])->name('leave-comment-post.{id}');
    Route::put('/form-show-datatables', [App\Http\Controllers\FormaController::class, 'showDatatable'])->name('form-show-datatables');
});


Route::get('/contacts', [App\Http\Controllers\ContactsController::class, 'index'])->name('contacts');
Route::get('/send-email', [App\Http\Controllers\ContactsController::class, 'sendEmail'])->name('send-email');


//Form Admin Routes
Route::middleware(['adminCheck'])->group(function () {
    Route::get('/show-comments', [App\Http\Controllers\FormaController::class, 'showComments'])->name('show-comments');

});
//Form Admin Routes End

//Profile Route
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
Route::post('/change-password', [App\Http\Controllers\ProfileController::class, 'changePassword'])->name('change-password');
Route::put('/profile-post', [App\Http\Controllers\ProfileController::class, 'profilePost'])->name('profile-post');
//Profile Route End

//Forum Route
Route::get('/forum', [App\Http\Controllers\ForumController::class, 'index'])->name('forum');
//Forum Route End
