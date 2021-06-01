<?php

namespace App\Http\Controllers;

use App\Models\ReleaseMovies;
use App\Models\Theater;
use App\Repositories\TheaterRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TheaterController extends Controller
{

    private $theaterRepo;
    public function __construct(TheaterRepository $theaterRepository)
    {
        $this->theaterRepo = $theaterRepository;
    }
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
     * @return false|\Illuminate\Http\Response|string
     */
    public function store(Request $request)
    {
        return $this->theaterRepo->save($request);
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
        return $this->theaterRepo->getTheaterById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Theater  $theater
     * @return false|\Illuminate\Http\Response|string
     */
    public function update(Request $request, Theater $theater,$id)
    {
        return $this->theaterRepo->update($request,$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Theater  $theater
     * @return false|\Illuminate\Http\Response|string
     */
    public function destroy(Theater $theater,$id)
    {
        return $this->theaterRepo->delete($id);
    }

    public function getAllTheaters(){
        return $this->theaterRepo->getAllTheaters();
    }

    public function getAllTheaterByCityId($id){
        return $this->theaterRepo->getAllTheaterByCityId($id);
    }
}
