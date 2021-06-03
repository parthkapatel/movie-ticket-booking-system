<?php


namespace App\Repositories;


use App\Interfaces\MovieDetailsInterface;
use App\Models\MovieDetails;

class MovieDetailsRepository implements MovieDetailsInterface
{

    private $movieDetails;

    public function __construct(MovieDetails $movieDetails)
    {
        $this->movieDetails = $movieDetails;
    }

    public function save($data)
    {
        $this->movieDetails->title = $data->title;
        $this->movieDetails->overview = $data->overview;
        $this->movieDetails->release_year = $data->release_year;
        $this->movieDetails->save();
        return $this->movieDetails;
    }


    public function update($data, $movie_id)
    {
        $this->movieDetails::find($movie_id);
        if($this->movieDetails){
            $this->movieDetails->title = $data->title;
            $this->movieDetails->overview = $data->overview;
            $this->movieDetails->release_year = $data->release_year;
            $this->movieDetails->save();
            return $this->movieDetails;
        }
        return "Movie not found";
    }

    public function delete($movie_id)
    {
        $this->movieDetails = MovieDetails::find($movie_id);
        if($this->movieDetails){
            $this->movieDetails->delete();
            return "Movie deleted successfully";
        }
        return "Movie not found";
    }

    public function getMovieById($movie_id)
    {
        return MovieDetails::find($movie_id);
    }

    public function getAllMovies()
    {
        return MovieDetails::orderBy("created_at","desc")->get();
    }

    public function getSearchMovie($str)
    {
        return MovieDetails::select('movie_details.*')
            ->join('release_movies', 'release_movies.movie_id', '=', 'movie_details.id')
            ->join('cities', 'release_movies.city_id', '=', 'cities.id')
            ->join('theaters', 'release_movies.theater_id', '=', 'theaters.id')
            ->where("movie_details.title" ,'LIKE', "%{$str}%")
            ->orWhere('cities.city_name', 'LIKE', "%{$str}%")
            ->orWhere('theaters.theater_name', 'LIKE', "%{$str}%")
            ->distinct()
            ->get();
    }
}
