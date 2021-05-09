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
    Route::get('/forma', [App\Http\Controllers\OrderController::class, 'index'])->name('forma');
    Route::put('/formpost', [App\Http\Controllers\OrderController::class, 'store'])->name('formpost');
    Route::get('/forma-all', [App\Http\Controllers\OrderController::class, 'showAll'])->name('forma-all');
    Route::get('/form-edit/{id}', [App\Http\Controllers\OrderController::class, 'formEdit'])->name('form-edit')->whereNumber('id');
    Route::put('/form-edit-post/{id}', [App\Http\Controllers\OrderController::class, 'formEditPost'])->name('form-edit-post')->whereNumber('id');
    Route::get('/form-delete/{id}', [App\Http\Controllers\OrderController::class, 'formDelete'])->name('form-delete')->whereNumber('id');
    Route::get('/download-guarantee/{id}', [App\Http\Controllers\OrderController::class, 'guaranteeDownload'])->name('download-guarantee')->whereNumber('id');
    Route::get('/leave-comment/{id}', [App\Http\Controllers\OrderController::class, 'leaveComment'])->name('leave-comment')->whereNumber('id');
    Route::put('/leave-comment-post/{id}', [App\Http\Controllers\OrderController::class, 'leaveCommentPost'])->name('leave-comment-post')->whereNumber('id');
    Route::post('/form-show-datatables', [App\Http\Controllers\OrderController::class, 'showDatatable'])->name('form-show-datatables');
});


Route::get('/contacts', [App\Http\Controllers\ContactsController::class, 'index'])->name('contacts');
Route::get('/send-email', [App\Http\Controllers\ContactsController::class, 'sendEmail'])->name('send-email');


//Form Admin Routes
Route::middleware(['adminCheck'])->group(function () {
    Route::get('/admin-users-list', [App\Http\Controllers\UsersController::class, 'usersListShow'])->name('admin-users-list');
    Route::post('/admin-users-list-datatable', [App\Http\Controllers\UsersController::class, 'usersListDatatable'])->name('admin-users-list-datatable');
    Route::put('/admin-user-edit/{id}', [App\Http\Controllers\UsersController::class, 'userEdit'])->name('admin-user-edit')->whereNumber('id');
    Route::get('/admin-user-edit-show/{id}', [App\Http\Controllers\UsersController::class, 'userEditShow'])->name('admin-user-edit-show')->whereNumber('id');
    Route::get('/admin-user-delete/{id}', [App\Http\Controllers\UsersController::class, 'userDelete'])->name('admin-user-delete')->whereNumber('id');
    Route::get('/admin-user-add-show', [App\Http\Controllers\UsersController::class, 'userAddShow'])->name('admin-user-add-show');
    Route::put('/admin-user-add', [App\Http\Controllers\UsersController::class, 'userAdd'])->name('admin-user-add');

});
//Form Admin Routes End

//Profile Route
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
Route::post('/change-password', [App\Http\Controllers\ProfileController::class, 'changePassword'])->name('change-password');
Route::put('/profile-post', [App\Http\Controllers\ProfileController::class, 'profilePost'])->name('profile-post');
//Profile Route End
