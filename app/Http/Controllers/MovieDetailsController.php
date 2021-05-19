<?php

namespace App\Http\Controllers;

use App\Models\MovieDetails;
use App\Models\ReleaseMovies;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class MovieDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Collection|MovieDetails[]
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
     * @return MovieDetails
     */
    public function store(Request $request)
    {
        $newMovie = new MovieDetails();
        $newMovie->title = $request->title;
        $newMovie->overview = $request->overview;
        $newMovie->release_year = $request->release_year;
        $newMovie->save();
        return $newMovie;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MovieDetails  $movieDetails
     * @return \Illuminate\Http\Response
     */
    public function show(MovieDetails $movieDetails,$id)
    {
        return MovieDetails::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MovieDetails  $movieDetails
     * @return \Illuminate\Http\Response
     */
    public function edit(MovieDetails $movieDetails,$id)
    {
        return MovieDetails::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MovieDetails  $movieDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MovieDetails $movieDetails,$id)
    {
        $existingMovie = MovieDetails::find($id);
        if($existingMovie){
            $existingMovie->title = $request->title;
            $existingMovie->overview = $request->overview;
            $existingMovie->release_year = $request->release_year;
            $existingMovie->save();
            return $existingMovie;
        }
        return "Movie not found";

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MovieDetails  $movieDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(MovieDetails $movieDetails,$id)
    {
        $existingMovie = MovieDetails::find($id);
        if($existingMovie){
            $existingMovie->delete();
            return "Movie deleted successfully";
        }
        return "Movie not found";
    }

    public function getAllMovies(){
        return MovieDetails::orderBy("created_at","desc")->get();
    }

    public function getSearchMovie($str){
        return ReleaseMovies::select('movie_details.*')
            ->join('cities', 'release_movies.city_id', '=', 'cities.id')
            ->join('theaters', 'release_movies.theater_id', '=', 'theaters.id')
            ->join('movie_details', 'release_movies.movie_id', '=', 'movie_details.id')
            ->where("movie_details.title" ,'LIKE', "%{$str}%")
            ->orWhere('cities.city_name', 'LIKE', "%{$str}%")
            ->orWhere('theaters.theater_name', 'LIKE', "%{$str}%")
            ->distinct()
            ->get();
    }
}
