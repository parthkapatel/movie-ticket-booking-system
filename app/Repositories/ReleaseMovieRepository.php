<?php


namespace App\Repositories;


use App\Interfaces\ReleaseMovieInterface;
use App\Models\ReleaseMovies;
use Illuminate\Support\Carbon;
use phpDocumentor\Reflection\Types\This;

class ReleaseMovieRepository implements ReleaseMovieInterface
{

    private $releaseMovieRepo;
    public function __construct(ReleaseMovies $releaseMovies)
    {
        $this->releaseMovieRepo = $releaseMovies;
    }

    public function save($data)
    {
        $this->releaseMovieRepo->city_id = $data->city_id;
        $this->releaseMovieRepo->theater_id = $data->theater_id;
        $this->releaseMovieRepo->movie_id = $data->movie_id;
        $this->releaseMovieRepo->runtime = implode('|', $data->runtime);
        $this->releaseMovieRepo->save();
        return $this->releaseMovieRepo;
    }

    public function update($data, $releaseMovie_id)
    {
        $this->releaseMovieRepo = $this->releaseMovieRepo::find($releaseMovie_id);
        if($this->releaseMovieRepo){
            $this->releaseMovieRepo->city_id = $data->city_id;
            $this->releaseMovieRepo->theater_id = $data->theater_id;
            $this->releaseMovieRepo->movie_id = $data->movie_id;
            $this->releaseMovieRepo->runtime = implode('|', $data->runtime);
            $this->releaseMovieRepo->save();
            return $this->releaseMovieRepo;
        }
        return "Release movie not found";
    }

    public function delete($releaseMovie_id)
    {
        $this->releaseMovieRepo = $this->releaseMovieRepo::find($releaseMovie_id);
        if($this->releaseMovieRepo){
            $this->releaseMovieRepo->delete();
            return "Release movie successfully deleted";
        }
        return "Release movie not found";
    }

    public function getReleaseMovieById($releaseMovie_id)
    {
        return $this->releaseMovieRepo::find($releaseMovie_id);
    }

    public function getAllAssignMovies()
    {
        return $this->releaseMovieRepo::select('cities.city_name','theaters.theater_name','movie_details.*','movie_details.id as movie_id','release_movies.runtime','release_movies.id')
            ->join('cities', 'release_movies.city_id', '=', 'cities.id')
            ->join('theaters', 'release_movies.theater_id', '=', 'theaters.id')
            ->join('movie_details', 'release_movies.movie_id', '=', 'movie_details.id')
            ->where("movie_details.release_year","<=",Carbon::now())
            ->orderBy('movie_details.release_year')
            ->orderBy('cities.city_name')
            ->get();
    }

    public function getMoviesForHome()
    {
        return $this->releaseMovieRepo::select('movie_details.*','release_movies.movie_id')
            ->join('movie_details', 'release_movies.movie_id', '=', 'movie_details.id')
            ->join('cities', 'release_movies.city_id', '=', 'cities.id')
            ->join('theaters', 'release_movies.theater_id', '=', 'theaters.id')
            ->where("movie_details.release_year","<=",Carbon::now())
            ->orderBy('movie_details.release_year')
            ->orderBy('cities.city_name')
            ->distinct()
            ->get();
    }

    public function getAllShowByCityAndTheaterIds($city_id, $theater_id, $movie_id)
    {
        $res =  $this->releaseMovieRepo::select("runtime")
            ->where("city_id",$city_id)
            ->where("theater_id",$theater_id)
            ->where("movie_id",$movie_id)
            ->get();
        if (count($res) == 0)
            return 0;
        return $res;
    }

    public function show($id)
    {
        return $this->releaseMovieRepo::select('cities.city_name','theaters.theater_name','movie_details.*','release_movies.runtime')
            ->join('cities', 'release_movies.city_id', '=', 'cities.id')
            ->join('theaters', 'release_movies.theater_id', '=', 'theaters.id')
            ->join('movie_details', 'release_movies.movie_id', '=', 'movie_details.id')
            ->where("movie_details.id","=",$id)
            ->get();
    }
}
