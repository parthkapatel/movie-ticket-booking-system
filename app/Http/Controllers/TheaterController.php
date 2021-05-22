<?php

namespace App\Http\Controllers;

use App\Models\ReleaseMovies;
use App\Models\Theater;
use Illuminate\Http\Request;

class TheaterController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newTheater = new Theater();
        $newTheater->theater_name = $request->theater_name;
        $newTheater->save();
        return $newTheater;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Theater  $theater
     * @return \Illuminate\Http\Response
     */
    public function show(Theater $theater)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Theater  $theater
     * @return \Illuminate\Http\Response
     */
    public function edit(Theater $theater,$id)
    {
        return Theater::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Theater  $theater
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Theater $theater,$id)
    {
        $existingTheater = Theater::find($id);
        if($existingTheater){
            $existingTheater->theater_name = $request->theater_name;
            $existingTheater->save();
            return $existingTheater;
        }
        return "Theater not found";

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Theater  $theater
     * @return \Illuminate\Http\Response
     */
    public function destroy(Theater $theater,$id)
    {
        $existingTheater = Theater::find($id);
        if($existingTheater){
            $existingTheater->delete();
            return "Theater Successfully deleted";
        }
        return "Theater Not found";
    }

    public function getAllTheaters(){
        return Theater::orderBy("theater_name")->get();
    }

    public function getAllTheaterByCityId($id){
        return ReleaseMovies::select("theaters.*")
            ->join("theaters","release_movies.theater_id","theaters.id")
            ->where("release_movies.city_id",$id)
            ->get();
    }
}
