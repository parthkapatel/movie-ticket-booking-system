<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Repositories\CityRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CityController extends Controller
{

    private $cityRepo;
    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepo = $cityRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
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
        return $this->cityRepo->save($request);
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
        return $this->cityRepo->getCityById($id);
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
       return $this->cityRepo->update($request,$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\City $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city, $id)
    {
        return $this->cityRepo->delete($id);
    }

    public function getAllCity()
    {
        return $this->cityRepo->getAllCity();
    }

    public function getCityByMovieId($movie_id)
    {
        return $this->cityRepo->getCityByMovieId($movie_id);
    }
}
