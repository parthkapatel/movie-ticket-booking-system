<?php

use App\Http\Controllers\BookTicketsController;
use App\Http\Controllers\CastController;
use App\Http\Controllers\CastsMoviesController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MovieDetailsController;
use App\Http\Controllers\ReleaseMoviesController;
use App\Http\Controllers\TheaterController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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


Route::post('/login', function (Request $request) {
    $data = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return json_encode([
            "status"=>"error",
            'message' => 'These credentials do not match our records.'
        ]);
    }

    $token = $user->createToken('my-app-token')->plainTextToken;

    $response = [
        'user' => $user,
        'token' => $token
    ];

    return response($response, 201);
});

Route::post('/register', function (Request $request) {
    $data = $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if ($user) {
        return json_encode([
            'error' => 'user is exists', 'status' => 'error'
        ]);
    } else {

        $token = Str::random(60);
        $user =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'api_token' => hash('sha256', $token),
        ]);
        if($user){
            return json_encode([
                'message' => 'Register Successfully', 'status' => 'success'
            ]);
        }else{
            return json_encode([
                'error' => 'something is wrong', 'status' => 'error'
            ]);
        }

    }
});

Route::middleware("auth:sanctum")->group(function () {
    Route::get("/user/id", [BookTicketsController::class, 'getAllBookedTicketsByUserId']);

    Route::get("/releaseMovie", [ReleaseMoviesController::class, "index"]);
    Route::get('/total/dashboard/', [Controller::class, 'getTotalsForDashboard']);


    Route::get("/getCities", [CityController::class, "index"]);
    Route::get("/city", [CityController::class, "create"]);
    Route::prefix("/city")->group(function () {
        Route::get("/get", [CityController::class, "getAllCity"]);
        Route::get("/getCity/{id}", [CityController::class, "getCityByMovieId"]);
        Route::post("/store", [CityController::class, 'store']);
        Route::get("/{id}", [CityController::class, 'edit']);
        Route::put("/{id}", [CityController::class, 'update']);
        Route::delete("/{id}", [CityController::class, 'destroy']);
    });


    Route::get("/getTheater", [TheaterController::class, "index"]);
    Route::get("/theater", [TheaterController::class, "create"]);
    Route::prefix("/theater")->group(function () {
        Route::get("/getTheater/{id}", [TheaterController::class, "getAllTheaterByCityId"]);
        Route::get("/get", [TheaterController::class, "getAllTheaters"]);
        Route::post("/store", [TheaterController::class, 'store']);
        Route::get("/{id}", [TheaterController::class, 'edit']);
        Route::put("/{id}", [TheaterController::class, 'update']);
        Route::delete("/{id}", [TheaterController::class, 'destroy']);
    });


    Route::get("/getMovies", [MovieDetailsController::class, "getAllMovies"]);
    Route::get("/movies", [MovieDetailsController::class, "create"]);
    Route::prefix("/movie")->group(function () {
        Route::get("/get", [MovieDetailsController::class, 'getAllMovies']);
        Route::post("/store", [MovieDetailsController::class, 'store']);
        Route::get("/{id}", [MovieDetailsController::class, 'edit']);
        Route::get("/show", [MovieDetailsController::class, 'show']);
        Route::post("/{id}", [MovieDetailsController::class, 'update']);
        Route::delete("/{id}", [MovieDetailsController::class, 'destroy']);
    });


    Route::get("/assign/movies", [ReleaseMoviesController::class, "create"]);
    Route::prefix("/assign")->group(function () {
        Route::get("/get", [ReleaseMoviesController::class, 'getAllAssignMovies']);
        Route::get("/getMoviesForHome", [ReleaseMoviesController::class, 'getMoviesForHome']);
        Route::post("/store", [ReleaseMoviesController::class, 'store']);
        Route::get("/{id}", [ReleaseMoviesController::class, 'edit']);
        Route::get("/{id}/show", [ReleaseMoviesController::class, 'show']);
        Route::post("/updateStatus", [ReleaseMoviesController::class, 'updateStatus']);
        Route::get("/movieShow/{cid}/{tid}/{mid}", [ReleaseMoviesController::class, 'getAllShowByCityAndTheaterIds']);
        Route::put("/{id}", [ReleaseMoviesController::class, 'update']);
        Route::delete("/{id}", [ReleaseMoviesController::class, 'destroy']);
    });


    Route::prefix("/cast")->group(function () {
        Route::get("/get", [CastController::class, 'getAllCasts']);
        Route::post("/store", [CastController::class, 'store']);
        Route::get("/{id}", [CastController::class, 'getCastDataById']);
        Route::post("/{id}", [CastController::class, 'update']);
        Route::delete("/{id}", [CastController::class, 'destroy']);
    });


    Route::get("/getCastsMovie", [CastsMoviesController::class, "index"]);
    Route::get("/castMovies", [CastsMoviesController::class, "create"]);
    Route::prefix("/castMovie")->group(function () {
        Route::get("/get", [CastsMoviesController::class, 'getAllCastMovies']);
        Route::post("/store", [CastsMoviesController::class, 'store']);
        Route::get("/{id}", [CastsMoviesController::class, 'getAllCastMoviesByMovieIds']);
        Route::get("/movie/{id}", [CastsMoviesController::class, 'getAllCastMoviesByCastIds']);
        Route::put("/{id}", [CastsMoviesController::class, 'update']);
        Route::delete("/{id}", [CastsMoviesController::class, 'destroy']);
    });

    Route::get("/search/{str}", [MovieDetailsController::class, "getSearchMovie"]);


    Route::get("/bookTickets", [BookTicketsController::class, "create"]);
    Route::prefix("/bookTicket")->group(function () {
        Route::get("/get", [BookTicketsController::class, 'getAllBookedTicketsByUserId']);
        Route::get("/getAll", [BookTicketsController::class, 'getAllUserBookedTickets']);
        Route::post("/getSeats", [BookTicketsController::class, 'getAllBookedSeats']);
        Route::post("/store", [BookTicketsController::class, 'store']);
        Route::get("/{id}", [BookTicketsController::class, 'getAllCastMoviesByMovieIds']);
        Route::get("/movie/{id}", [BookTicketsController::class, 'getAllCastMoviesByCastIds']);
        Route::put("/{id}", [BookTicketsController::class, 'update']);
        Route::delete("/{id}", [BookTicketsController::class, 'destroy']);
    });


});

