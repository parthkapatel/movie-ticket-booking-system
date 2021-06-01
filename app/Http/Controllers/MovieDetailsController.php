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
     * @return Collection|MovieDetails[]
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MovieDetails $movieDetails,$id)
    {

        $this->movieDetails = $this->movieDetails::find($id);
        if($this->movieDetails){
            $this->movieDetails->title = $request->title;
            $this->movieDetails->overview = $request->overview;
            $this->movieDetails->release_year = $request->release_year;
            $this->movieDetails->save();
            return $this->movieDetails;
        }
        return "Movie not found";

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MovieDetails  $movieDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(MovieDetails $movieDetails,$id)
    {
        $this->movieDetails = $this->movieDetails::find($id);
        if($this->movieDetails){
            $this->movieDetails->delete();
            return "Movie deleted successfully";
        }
        return "Movie not found";
    }

    public function getAllMovies(){
        return $this->movieDetails->getAllMovies();
    }

    public function getSearchMovie($str){
        return $this->movieDetails->getSearchMovie($str);
    }
}
