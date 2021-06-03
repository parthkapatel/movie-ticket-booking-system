<?php

namespace App\Http\Controllers;

use App\Models\MovieDetails;
use App\Models\ReleaseMovies;
use App\Repositories\MovieDetailsRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class MovieDetailsController extends Controller
{
    private $movieDetails;
    public function __construct(MovieDetailsRepository $movieDetailsRepository)
    {
        $this->movieDetails = $movieDetailsRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return MovieDetails[]|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Collection
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
     * @return MovieDetails
     */
    public function store(Request $request)
    {
        return $this->movieDetails->save($request);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MovieDetails  $movieDetails
     * @return \Illuminate\Http\Response
     */
    public function show(MovieDetails $movieDetails,$id)
    {
        return $this->movieDetails->getMovieById($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MovieDetails  $movieDetails
     * @return \Illuminate\Http\Response
     */
    public function edit(MovieDetails $movieDetails,$id)
    {
        return $this->movieDetails->getMovieById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MovieDetails  $movieDetails
     * @return MovieDetails|\Illuminate\Http\Response|string
     */
    public function update(Request $request, MovieDetails $movieDetails,$id)
    {

        return $this->movieDetails->update($request,$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MovieDetails  $movieDetails
     * @return string
     */
    public function destroy(MovieDetails $movieDetails,$id)
    {
        return $this->movieDetails->delete($id);
    }

    public function getAllMovies(){
        return $this->movieDetails->getAllMovies();
    }

    public function getSearchMovie($str){
        return $this->movieDetails->getSearchMovie($str);
    }
}
