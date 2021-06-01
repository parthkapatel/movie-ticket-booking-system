<?php

namespace App\Http\Controllers;

use App\Models\ReleaseMovies;
use App\Repositories\ReleaseMovieRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReleaseMoviesController extends Controller
{

    private $releaseRepo;
    public function __construct(ReleaseMovieRepository $releaseMovieRepository)
    {
        $this->releaseRepo = $releaseMovieRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Collection|ReleaseMovies[]
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
        return $this->releaseRepo->save($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReleaseMovies  $releaseMovies
     * @return \Illuminate\Http\Response
     */
    public function show(ReleaseMovies $releaseMovies,$id)
    {
        return $this->releaseRepo->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReleaseMovies  $releaseMovies
     * @return \Illuminate\Http\Response
     */
    public function edit(ReleaseMovies $releaseMovies,$id)
    {
        return $this->releaseRepo->getReleaseMovieById($id);
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
        return $this->releaseRepo->update($request,$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReleaseMovies  $releaseMovies
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReleaseMovies $releaseMovies,$id)
    {
        return $this->releaseRepo->delete($id);
    }

    public function getAllAssignMovies(){
        return $this->releaseRepo->getAllAssignMovies();
    }

    public function getMoviesForHome(){
        return $this->releaseRepo->getMoviesForHome();
    }

    public function getAllShowByCityAndTheaterIds($cid,$tid,$mid){
        return $this->releaseRepo->getAllShowByCityAndTheaterIds($cid,$tid,$mid);
    }
}
