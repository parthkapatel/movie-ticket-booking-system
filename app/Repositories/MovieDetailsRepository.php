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

    public function save($data,$file_path)
    {

        $this->movieDetails->title = $data->title;
        $this->movieDetails->overview = $data->overview;
        $this->movieDetails->release_year = $data->release_year;
        $this->movieDetails->image_path = $file_path;
        $this->movieDetails->save();
        return $this->movieDetails;
    }


    public function update($movie_id,$data,$file_path)
    {
        $exisiting = $this->movieDetails::find($movie_id);
        if($exisiting){
            $exisiting->title = $data->title;
            $exisiting->overview = $data->overview;
            $exisiting->release_year = $data->release_year;
            $exisiting->image_path = $file_path;
            $exisiting->save();
            return $exisiting;
        }
        return "Movie not found";
    }

    public function delete($movie_id)
    {
        if($this->movieDetails::destroy($movie_id)){
            return "Movie deleted successfully";
        }
        return "Movie not found";
    }

    public function getMovieById($movie_id)
    {
        return $this->movieDetails::find($movie_id);
    }

    public function getAllMovies()
    {
        return $this->movieDetails::orderBy("created_at","desc")->get();
    }

    public function getSearchMovie($str)
    {
        return $this->movieDetails::select('movie_details.*')
            ->join('release_movies', 'release_movies.movie_id', '=', 'movie_details.id')
            ->join('cities', 'release_movies.city_id', '=', 'cities.id')
            ->join('theaters', 'release_movies.theater_id', '=', 'theaters.id')
            ->where("movie_details.title" ,'LIKE', "%{$str}%")
            ->orWhere('cities.city_name', 'LIKE', "%{$str}%")
            ->orWhere('theaters.theater_name', 'LIKE', "%{$str}%")
            ->where("release_movies.status","=","release")
            ->distinct()
            ->get();
    }
}
