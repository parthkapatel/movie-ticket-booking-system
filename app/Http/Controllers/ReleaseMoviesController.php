<?php

namespace App\Http\Controllers;

use App\Models\ReleaseMovies;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReleaseMoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Collection|ReleaseMovies[]
     */
    public function index()
    {
        return view("index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newRelease = new ReleaseMovies();
        $newRelease->city_id = $request->city_id;
        $newRelease->theater_id = $request->theater_id;
        $newRelease->movie_id = $request->movie_id;
        $newRelease->runtime = implode('|', $request->runtime);
        $newRelease->save();
        return $newRelease;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReleaseMovies  $releaseMovies
     * @return \Illuminate\Http\Response
     */
    public function show(ReleaseMovies $releaseMovies,$id)
    {
        return ReleaseMovies::select('cities.city_name','theaters.theater_name','movie_details.*','release_movies.runtime')
            ->join('cities', 'release_movies.city_id', '=', 'cities.id')
            ->join('theaters', 'release_movies.theater_id', '=', 'theaters.id')
            ->join('movie_details', 'release_movies.movie_id', '=', 'movie_details.id')
            ->where("movie_details.id","=",$id)
            ->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReleaseMovies  $releaseMovies
     * @return \Illuminate\Http\Response
     */
    public function edit(ReleaseMovies $releaseMovies,$id)
    {
           return $releaseMovies::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReleaseMovies  $releaseMovies
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReleaseMovies $releaseMovies,$id)
    {
        $existingRelease = ReleaseMovies::find($id);
        if($existingRelease){
            $existingRelease->city_id = $request->city_id;
            $existingRelease->theater_id = $request->theater_id;
            $existingRelease->movie_id = $request->movie_id;
            $existingRelease->runtime = implode('|', $request->runtime);
            $existingRelease->save();
            return $existingRelease;
        }
        return "Release movie not found";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReleaseMovies  $releaseMovies
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReleaseMovies $releaseMovies,$id)
    {
        $existingRelease = ReleaseMovies::find($id);
        if($existingRelease){
            $existingRelease->delete();
            return "Release movie successfully deleted";
        }
        return "Release movie not found";
    }

    public function getAllAssignMovies(){
        return ReleaseMovies::select('cities.city_name','theaters.theater_name','movie_details.*','movie_details.id as movie_id','release_movies.runtime','release_movies.id')
            ->join('cities', 'release_movies.city_id', '=', 'cities.id')
            ->join('theaters', 'release_movies.theater_id', '=', 'theaters.id')
            ->join('movie_details', 'release_movies.movie_id', '=', 'movie_details.id')
            ->where("movie_details.release_year","<=",Carbon::now())
            ->orderBy('movie_details.release_year')
            ->orderBy('cities.city_name')
            ->get();
    }

    public function getMoviesForHome(){
        return ReleaseMovies::select('movie_details.*','release_movies.movie_id')
            ->join('movie_details', 'release_movies.movie_id', '=', 'movie_details.id')
            ->join('cities', 'release_movies.city_id', '=', 'cities.id')
            ->join('theaters', 'release_movies.theater_id', '=', 'theaters.id')
            ->where("movie_details.release_year","<=",Carbon::now())
            ->orderBy('movie_details.release_year')
            ->orderBy('cities.city_name')
            ->distinct()
            ->get();
    }

    public function getAllShowByCityAndTheaterIds($cid,$tid){
        return ReleaseMovies::select("runtime")
            ->where("city_id",$cid)
            ->where("theater_id",$tid)
            ->get();
    }
}
