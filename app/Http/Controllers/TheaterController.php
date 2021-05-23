<?php

namespace App\Http\Controllers;

use App\Models\ReleaseMovies;
use App\Models\Theater;
use Illuminate\Database\Eloquent\Model;
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
        $exisitingCity = Theater::where("theater_name", $request->theater_name)->first();
        if ($exisitingCity) {
            return json_encode(["status" => "error", "message" => "Theater already exists!"]);
        } else {
            $newTheater = new Theater();
            $newTheater->theater_name = $request->theater_name;
            $newTheater->save();
            return json_encode(["status"=>"success","message"=>"Theater Successfully Added"]);
        }
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
        $childData = Theater::join("release_movies", "release_movies.theater_id", "theaters.id")->where("theaters.id", $id)->get()->count();
        if ($childData > 0) {
            return json_encode(["status"=>"error","message"=>"you can not update this data after assign movie"]);
        } else {
            $existingTheater = Theater::find($id);
            if($existingTheater){
                $existingTheater->theater_name = $request->theater_name;
                $existingTheater->save();
                return json_encode(["status"=>"success","message"=>"Theater Successfully Updated"]);
            }
            return json_encode(["status"=>"error","message"=>"Theater Not Found"]);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Theater  $theater
     * @return \Illuminate\Http\Response
     */
    public function destroy(Theater $theater,$id)
    {
        $childData = Theater::join("release_movies", "release_movies.theater_id", "theaters.id")->where("theaters.id", $id)->get()->count();
        if ($childData > 0) {
            return json_encode(["status"=>"error","message"=>"you can not delete this data after assign movie"]);
        } else {
            $existingTheater = Theater::find($id);
            if($existingTheater){
                $existingTheater->delete();
                return json_encode(["status"=>"success","message"=>"Theater Successfully deleted"]);
            }
            return json_encode(["status"=>"error","message"=>"Theater Not Found"]);
        }
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
