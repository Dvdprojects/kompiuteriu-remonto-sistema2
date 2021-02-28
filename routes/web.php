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
Route::get('/naujas', [App\Http\Controllers\NaujasController::class, 'index'])->name('naujas');
Route::get('/forma', [App\Http\Controllers\FormaController::class, 'index'])->name('forma');
Route::put('/formpost', [App\Http\Controllers\FormaController::class, 'store'])->name('formpost');
Route::get('/forma-all', [App\Http\Controllers\FormaController::class, 'showAll'])->name('forma-all');
