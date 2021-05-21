<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookTicketsController;
use App\Http\Controllers\CastController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieDetailsController;
use App\Http\Controllers\TheaterController;
use Illuminate\Support\Facades\Auth;
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



Route::get('/', [Controller::class,'index'])->middleware('auth');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('admin/home', [AdminController::class,'index'])->name('admin.route')->middleware("auth")->middleware('isAdmin');

Route::get('user/{vue?}', [HomeController::class,'index'])->where('vue', '[\/\w\@\.-]*')->middleware("auth");

//Route::get("/{any}",[Controller::class,'index'])->where('vue', '[\/\w\@\.-]*');

Route::get('city/{vue?}', [CityController::class,'index'])->where('vue', '[\/\w\@\.-]*')->middleware("auth")->middleware('isAdmin');
Route::get('theater/{vue?}', [TheaterController::class,'index'])->where('vue', '[\/\w\@\.-]*')->middleware("auth")->middleware('isAdmin');
Route::get('movie/{vue?}', [MovieDetailsController::class,'index'])->where('vue', '[\/\w\@\.-]*')->middleware("auth")->middleware('isAdmin');
Route::get('cast/{vue?}', [CastController::class,'index'])->where('vue', '[\/\w\@\.-]*')->middleware("auth")->middleware('isAdmin');

Route::get('/bookTicket/{vue?}', [BookTicketsController::class,'index'])->where('vue', '[\/\w\@\.-]*')->middleware("auth")->middleware('isAdmin');
Route::get('/bookTicket/confirm', [BookTicketsController::class,'index'])->where('vue', '[\/\w\@\.-]*')->middleware("auth")->middleware('isAdmin');



