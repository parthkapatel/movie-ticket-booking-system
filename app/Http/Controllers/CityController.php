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
        return view("index")->with("cities",City::all());
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
     * @param  \Illuminate\Http\Request  $request
     * @return City
     */
    public function store(Request $request): City
    {
        $newCity = new City();
        $newCity->city_name = $request->city_name;
        $newCity->save();
        return $newCity;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city,$id)
    {
        return City::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city,$id)
    {
        $existingCity = City::find($id);
        if($existingCity){
            $existingCity->city_name = $request->city_name;
            $existingCity->save();
            return $existingCity;
        }
        return "City not found";

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city,$id)
    {
        $existingCity = City::find($id);
        if($existingCity){
            $existingCity->delete();
            return "City Successfully deleted";
        }
        return "City not found";
    }

    public function getAllCity(){
        return City::orderBy("city_name")->get();
    }
}
