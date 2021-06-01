<?php

namespace App\Http\Controllers;

use App\Models\CastsMovies;
use App\Repositories\CastMoviesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CastsMoviesController extends Controller
{

    private $castMovieRepo;
    public function __construct(CastMoviesRepository $castMoviesRepository)
    {
        $this->castMovieRepo = $castMoviesRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
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
     * @return false|\Illuminate\Http\Response|string
     */
    public function store(Request $request)
    {
        return $this->castMovieRepo->save($request);
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
        return $this->castMovieRepo->getCastMovieById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CastsMovies $castsMovies
     * @return false|\Illuminate\Http\Response|string
     */
    public function update(Request $request, CastsMovies $castsMovies, $id)
    {
        return $this->castMovieRepo->update($request,$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\CastsMovies $castsMovies
     * @return string
     */
    public function destroy(CastsMovies $castsMovies, $id)
    {
       return $this->castMovieRepo->delete($id);
    }

    public function getAllCastMovies()
    {
      return $this->castMovieRepo->getAllCastMovies();
    }

    public function getAllCastMoviesByMovieIds($id)
    {
        return $this->castMovieRepo->getAllCastMoviesByMovieIds($id);
    }

    public function getAllCastMoviesByCastIds($id)
    {
        return $this->castMovieRepo->getAllCastMoviesByCastIds($id);
    }
}
