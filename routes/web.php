<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
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

Route::middleware('guest')->group(function(){
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'auth']);
    Route::get('register', [AuthController::class, 'register']);
    Route::post('register', [AuthController::class, 'regis']);
    });

Route::middleware('auth')->group(function(){
    Route::get('profile',[UserController::class, 'profile'])->middleware('only_client');
    Route::get('dashboard',[AdminController::class, 'index'])->middleware('only_admin');
    Route::get('category',[AdminController::class, 'categorys'])->middleware('only_admin');
    Route::get('category-add',[AdminController::class, 'categoryAdd'])->middleware('only_admin');
    Route::post('category-add',[AdminController::class, 'categoryStore'])->middleware('only_admin');
    Route::get('category-edit/{slug}',[AdminController::class, 'categoryEdit'])->middleware('only_admin');
    Route::put('category-edit/{slug}',[AdminController::class, 'categoryUpdate'])->middleware('only_admin');
    Route::get('category-delete/{slug}',[AdminController::class, 'categoryDestroy'])->middleware('only_admin');
    Route::get('users',[AdminController::class, 'users'])->middleware('only_admin');
    Route::get('book',[AdminController::class, 'books'])->middleware('only_admin');
    Route::get('book-add',[AdminController::class, 'booksAdd']);
    Route::post('book-add',[AdminController::class, 'booksStore']);
    Route::get('rentlogs',[AdminController::class, 'rentlogs'])->middleware('only_admin');
    Route::get('logout', [AuthController::class, 'logout']);
});

