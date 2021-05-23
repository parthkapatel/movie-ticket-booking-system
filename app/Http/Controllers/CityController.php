<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CityController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return City[]|Collection
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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return City
     */
    public function store(Request $request)
    {
        $exisitingCity = City::where("city_name", $request->city_name)->first();
        if ($exisitingCity) {
            return json_encode(["status" => "error", "message" => "City already exists!"]);
        } else {
            $newCity = new City();
            $newCity->city_name = $request->city_name;
            $newCity->save();
            return json_encode(["status"=>"success","message"=>"City Successfully Added"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\City $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\City $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city, $id)
    {
        return City::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\City $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city, $id)
    {
        $childData = City::join("release_movies", "release_movies.city_id", "cities.id")->where("cities.id", $id)->get()->count();
        if ($childData > 0) {
            return json_encode(["status"=>"error","message"=>"you can not update this data after assign movie or theater"]);
        } else {
            $existingCity = City::find($id);
            if ($existingCity) {
                $existingCity->city_name = $request->city_name;
                $existingCity->save();
                return json_encode(["status"=>"success","message"=>"City Successfully Updated"]);
            }
            return json_encode(["status"=>"error","message"=>"City Not Found"]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\City $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city, $id)
    {
        $childData = City::join("release_movies", "release_movies.city_id", "cities.id")->where("cities.id", $id)->get()->count();
        if ($childData > 0) {
            return json_encode(["status"=>"error","message"=>"you can not delete this data after assign movie or theater"]);
        } else {
            $existingCity = City::find($id);
            if ($existingCity) {
                $existingCity->delete();
                return json_encode(["status"=>"success","message"=>"City Successfully deleted"]);
            }
            return json_encode(["status"=>"error","message"=>"City Not Found"]);
        }
    }

    public function getAllCity()
    {
        return City::orderBy("city_name")->get();
    }
}
