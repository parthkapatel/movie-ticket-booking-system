<?php

namespace App\Http\Controllers;

use App\Models\BookTickets;
use App\Models\Cast;
use App\Models\City;
use App\Models\MovieDetails;
use App\Models\Theater;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(){
        return view("index");
    }

    public function getTotalsForDashboard(){
        $cities = City::all()->count();
        $theaters = Theater::all()->count();
        $movies = MovieDetails::all()->count();
        $releaseMovies = MovieDetails::where("release_year","<=",Carbon::now())->get()->count();
        $upcomingMovies = MovieDetails::where("release_year",">",Carbon::now())->get()->count();
        $casts = Cast::all()->count();
        $booked = BookTickets::all()->count();
        return json_encode(["cities"=>$cities,"theaters"=>$theaters,
            "movies"=>$movies,"casts"=>$casts,"releaseMovie"=>$releaseMovies,
            "upcomingMovie"=>$upcomingMovies,"totalBookedTickets"=>$booked
        ]);
    }
}
