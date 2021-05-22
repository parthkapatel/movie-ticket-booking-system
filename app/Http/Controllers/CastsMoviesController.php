<?php

namespace App\Http\Controllers;

use App\Models\CastsMovies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CastsMoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("welcome");
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newCastMovie = new CastsMovies();
        $newCastMovie->cast_id = $request->cast_id;
        $newCastMovie->movie_id = $request->movie_id;
        $newCastMovie->save();
        return $newCastMovie;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\CastsMovies $castsMovies
     * @return \Illuminate\Http\Response
     */
    public function show(CastsMovies $castsMovies)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\CastsMovies $castsMovies
     * @return \Illuminate\Http\Response
     */
    public function edit(CastsMovies $castsMovies, $id)
    {
        return CastsMovies::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CastsMovies $castsMovies
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CastsMovies $castsMovies, $id)
    {
        $existingCastMovie = CastsMovies::find($id);
        if ($existingCastMovie) {
            $existingCastMovie->cast_id = $request->cast_id;
            $existingCastMovie->movie_id = $request->movie_id;
            $existingCastMovie->save();
            return $existingCastMovie;
        }
        return "Cast Movie Not Found!";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\CastsMovies $castsMovies
     * @return \Illuminate\Http\Response
     */
    public function destroy(CastsMovies $castsMovies, $id)
    {
        $existingCastMovie = CastsMovies::find($id);
        if ($existingCastMovie) {
            $existingCastMovie->delete();
            return "Cast Movie Successfully deleted";
        }
        return "Cast Movie not found";
    }

    public function getAllCastMovies()
    {
        return CastsMovies::select("casts.name", "movie_details.title", "casts_movies.id")
            ->join("movie_details", "movie_details.id", "casts_movies.movie_id")
            ->join("casts", "casts.id", "casts_movies.cast_id")
            ->orderBy("movie_details.title")
            ->get();
    }

    public function getAllCastMoviesByMovieIds($id)
    {
        return CastsMovies::select("casts.*")
            ->join("casts","casts.id","casts_movies.cast_id")
            ->where("movie_id",$id)
            ->get();
    }

    public function getAllCastMoviesByCastIds($id)
    {
        return CastsMovies::select("movie_details.*")
            ->join("movie_details","movie_details.id","casts_movies.movie_id")
            ->where("casts_movies.cast_id",$id)
            ->get();
    }
}
