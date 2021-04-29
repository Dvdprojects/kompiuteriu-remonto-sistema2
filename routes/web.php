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
    Route::get('/form-edit/{id}', [App\Http\Controllers\FormaController::class, 'formEdit'])->name('form-edit')->whereNumber('id');
    Route::put('/form-edit-post/{id}', [App\Http\Controllers\FormaController::class, 'formEditPost'])->name('form-edit-post')->whereNumber('id');
    Route::get('/form-delete/{id}', [App\Http\Controllers\FormaController::class, 'formDelete'])->name('form-delete')->whereNumber('id');
    Route::get('/download-guarantee/{id}', [App\Http\Controllers\FormaController::class, 'guaranteeDownload'])->name('download-guarantee')->whereNumber('id');
    Route::get('/leave-comment/{id}', [App\Http\Controllers\FormaController::class, 'leaveComment'])->name('leave-comment')->whereNumber('id');
    Route::put('/leave-comment-post/{id}', [App\Http\Controllers\FormaController::class, 'leaveCommentPost'])->name('leave-comment-post')->whereNumber('id');
    Route::post('/form-show-datatables', [App\Http\Controllers\FormaController::class, 'showDatatable'])->name('form-show-datatables');
});


Route::get('/contacts', [App\Http\Controllers\ContactsController::class, 'index'])->name('contacts');
Route::get('/send-email', [App\Http\Controllers\ContactsController::class, 'sendEmail'])->name('send-email');


//Form Admin Routes
Route::middleware(['adminCheck'])->group(function () {
    Route::get('/admin-forum', [App\Http\Controllers\ForumController::class, 'forumAdmin'])->name('admin-forum');
    Route::get('/admin-users-list', [App\Http\Controllers\UsersController::class, 'usersListShow'])->name('admin-users-list');
    Route::post('/admin-users-list-datatable', [App\Http\Controllers\UsersController::class, 'usersListDatatable'])->name('admin-users-list-datatable');
    Route::post('/admin-user-edit/{id}', [App\Http\Controllers\UsersController::class, 'userEdit'])->name('admin-user-edit')->whereNumber('id');
    Route::get('/admin-user-edit-show/{id}', [App\Http\Controllers\UsersController::class, 'userEditShow'])->name('admin-user-edit-show')->whereNumber('id');
    Route::delete('/admin-user-delete/{id}', [App\Http\Controllers\UsersController::class, 'userDelete'])->name('admin-user-delete')->whereNumber('id');

});
//Form Admin Routes End

//Profile Route
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
Route::post('/change-password', [App\Http\Controllers\ProfileController::class, 'changePassword'])->name('change-password');
Route::put('/profile-post', [App\Http\Controllers\ProfileController::class, 'profilePost'])->name('profile-post');
//Profile Route End

//Forum Route
Route::get('/forum', [App\Http\Controllers\ForumController::class, 'index'])->name('forum');
Route::get('/forum-post-add-view', [App\Http\Controllers\ForumController::class, 'forumPostAddView'])->name('forum-post-add-view');
Route::put('/forum-post', [App\Http\Controllers\ForumController::class, 'forumPost'])->name('forum-post');
Route::get('/forum-post-open/{id}', [App\Http\Controllers\ForumController::class, 'viewForumPosts'])->name('forum-post-open')->whereNumber('id');
Route::put('/leave-forum-post-comment/{id}', [App\Http\Controllers\ForumController::class, 'leaveForumPostComment'])->name('leave-forum-post-comment')->whereNumber('id');
Route::get('/forum/lessons', [App\Http\Controllers\ForumController::class, 'lessons'])->name('forum.lessons');
Route::get('/forum/questions', [App\Http\Controllers\ForumController::class, 'questions'])->name('forum.questions');
Route::get('/forum/specialist', [App\Http\Controllers\ForumController::class, 'specialistQuestions'])->name('forum.specialist');
Route::get('/forum/duk', [App\Http\Controllers\ForumController::class, 'duk'])->name('forum.duk');
Route::get('/forum/reviews', [App\Http\Controllers\ForumController::class, 'reviews'])->name('forum.reviews');
Route::get('/forum-post-accept/{id}', [App\Http\Controllers\ForumController::class, 'acceptForumPost'])->name('forum-post-accept')->whereNumber('id');
Route::get('/forum-post-deny/{id}', [App\Http\Controllers\ForumController::class, 'denyForumPost'])->name('forum-post-deny')->whereNumber('id');
//Forum Route End
