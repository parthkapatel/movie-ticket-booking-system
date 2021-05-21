<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApiTokenController;
use App\Http\Controllers\BookTicketsController;
use App\Http\Controllers\CastController;
use App\Http\Controllers\CastsMoviesController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MovieDetailsController;
use App\Http\Controllers\ReleaseMoviesController;
use App\Http\Controllers\TheaterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/login",[\App\Http\Controllers\Auth\LoginController::class,'login']);
//get token
Route::get("/token",[ApiTokenController::class,"update"]);

Route::get("/releaseMovie",[ReleaseMoviesController::class,"index"]);
Route::get('/total/dashboard/',[Controller::class,'getTotalsForDashboard']);


Route::get("/getCities",[CityController::class,"index"]);
Route::get("/city",[CityController::class,"create"]);
Route::prefix("/city")->group(function (){
    Route::get("/get",[CityController::class,"getAllCity"]);
    Route::post("/store",[CityController::class,'store']);
    Route::get("/{id}",[CityController::class,'edit']);
    Route::put("/{id}",[CityController::class,'update']);
    Route::delete("/{id}",[CityController::class,'destroy']);
});


Route::get("/getTheater",[TheaterController::class,"index"]);
Route::get("/theater",[TheaterController::class,"create"]);
Route::prefix("/theater")->group(function (){
    Route::get("/getTheater/{id}",[TheaterController::class,"getAllTheaterByCityId"]);
    Route::get("/get",[TheaterController::class,"getAllTheaters"]);
    Route::post("/store",[TheaterController::class,'store']);
    Route::get("/{id}",[TheaterController::class,'edit']);
    Route::put("/{id}",[TheaterController::class,'update']);
    Route::delete("/{id}",[TheaterController::class,'destroy']);
});


Route::get("/getMovies",[MovieDetailsController::class,"getAllMovies"]);
Route::get("/movies",[MovieDetailsController::class,"create"]);
Route::prefix("/movie")->group(function (){
    Route::get("/get",[MovieDetailsController::class,'getAllMovies']);
    Route::post("/store",[MovieDetailsController::class,'store']);
    Route::get("/{id}",[MovieDetailsController::class,'edit']);
    Route::get("/show",[MovieDetailsController::class,'show']);
    Route::put("/{id}",[MovieDetailsController::class,'update']);
    Route::delete("/{id}",[MovieDetailsController::class,'destroy']);
});


Route::get("/getAssignMovies",[ReleaseMoviesController::class,"index"]);
Route::get("/assign/movies",[ReleaseMoviesController::class,"create"]);
Route::prefix("/assign")->group(function (){
    Route::get("/get",[ReleaseMoviesController::class,'getAllAssignMovies']);
    Route::get("/getMoviesForHome",[ReleaseMoviesController::class,'getMoviesForHome']);
    Route::post("/store",[ReleaseMoviesController::class,'store']);
    Route::get("/{id}",[ReleaseMoviesController::class,'edit']);
    Route::get("/{id}/show",[ReleaseMoviesController::class,'show']);
    Route::get("/movieShow/{cid}/{tid}",[ReleaseMoviesController::class,'getAllShowByCityAndTheaterIds']);
    Route::put("/{id}",[ReleaseMoviesController::class,'update']);
    Route::delete("/{id}",[ReleaseMoviesController::class,'destroy']);
});


Route::get("/getCasts",[CastController::class,"index"]);
Route::get("/casts",[CastController::class,"create"]);
Route::prefix("/cast")->group(function (){
    Route::post("/getIds",[CastController::class,'getCastsByIds']);
    Route::get("/get",[CastController::class,'getALlCasts']);
    Route::post("/store",[CastController::class,'store']);
    Route::get("/{id}",[CastController::class,'edit']);
    Route::put("/{id}",[CastController::class,'update']);
    Route::delete("/{id}",[CastController::class,'destroy']);
});


Route::get("/getCastsMovie",[CastsMoviesController::class,"index"]);
Route::get("/castMovies",[CastsMoviesController::class,"create"]);
Route::prefix("/castMovie")->group(function (){
    Route::get("/get",[CastsMoviesController::class,'getAllCastMovies']);
    Route::post("/store",[CastsMoviesController::class,'store']);
    Route::get("/{id}",[CastsMoviesController::class,'getAllCastMoviesByMovieIds']);
    Route::get("/movie/{id}",[CastsMoviesController::class,'getAllCastMoviesByCastIds']);
    Route::put("/{id}",[CastsMoviesController::class,'update']);
    Route::delete("/{id}",[CastsMoviesController::class,'destroy']);
});

Route::get("/search/{str}",[MovieDetailsController::class,"getSearchMovie"]);


Route::get("/bookTickets",[BookTicketsController::class,"create"]);
Route::prefix("/bookTicket")->group(function (){
    Route::get("/get",[BookTicketsController::class,'getAllBookedTicketsByUserId']);
    Route::get("/getAll",[BookTicketsController::class,'getAllUserBookedTickets']);
    Route::post("/getSeats",[BookTicketsController::class,'getAllBookedSeats']);
    Route::post("/store",[BookTicketsController::class,'store']);
    Route::get("/{id}",[BookTicketsController::class,'getAllCastMoviesByMovieIds']);
    Route::get("/movie/{id}",[BookTicketsController::class,'getAllCastMoviesByCastIds']);
    Route::put("/{id}",[BookTicketsController::class,'update']);
    Route::delete("/{id}",[BookTicketsController::class,'destroy']);
});

