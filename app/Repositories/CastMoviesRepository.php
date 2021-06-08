<?php


namespace App\Repositories;


use App\Interfaces\CastMoviesInterface;
use App\Models\CastsMovies;

class CastMoviesRepository implements CastMoviesInterface
{
    private $castMovieRepo;
    public function __construct(CastsMovies $castsMovies)
    {
        $this->castMovieRepo = $castsMovies;
    }

    public function save($data)
    {
        $existsData = $this->castMovieRepo::where("cast_id",$data->cast_id)->where("movie_id", $data->movie_id)->get()->count();
        if ($existsData > 0) {
            return json_encode(["status"=>"error","message"=>"you can not reassign the same movie to cast"]);
        } else {
            $this->castMovieRepo->cast_id = $data->cast_id;
            $this->castMovieRepo->movie_id = $data->movie_id;
            $this->castMovieRepo->save();
            return json_encode(["status"=>"success","message"=>"Movie Assign to Cast Successfully"]);
        }
    }

    public function update($data, $castMovie_id)
    {
        $existsData = $this->castMovieRepo::where("cast_id",$data->cast_id)->where("movie_id", $data->movie_id)->get()->count();
        if ($existsData > 0) {
            return json_encode(["status"=>"error","message"=>"you try to assign movie that data is already exists"]);
        } else {
            $this->castMovieRepo = $this->castMovieRepo::find($castMovie_id);
            if ($this->castMovieRepo) {
                $this->castMovieRepo->cast_id = $data->cast_id;
                $this->castMovieRepo->movie_id = $data->movie_id;
                $this->castMovieRepo->save();
                return json_encode(["status"=>"success","message"=>"Movie reassign to cast successfully Updated"]);
            }
            return json_encode(["status"=>"error","message"=>"Data Not Found"]);
        }
    }

    public function delete($castMovie_id): string
    {
        if($this->castMovieRepo::destroy($castMovie_id)){
            return "Cast Movie Successfully deleted";
        }
        return "Cast Movie not found";
    }

    public function getCastMovieById($castMovie_id)
    {
        return $this->castMovieRepo::find($castMovie_id);
    }

    public function getAllCastMovies()
    {
        return $this->castMovieRepo::select("casts.name", "movie_details.title", "casts_movies.id")
            ->join("movie_details", "movie_details.id", "casts_movies.movie_id")
            ->join("casts", "casts.id", "casts_movies.cast_id")
            ->orderBy("movie_details.title")
            ->get();
    }

    public function getAllCastMoviesByMovieIds($movie_id)
    {
        return $this->castMovieRepo::select("casts.*")
            ->join("casts","casts.id","casts_movies.cast_id")
            ->where("movie_id",$movie_id)
            ->get();
    }

    public function getAllCastMoviesByCastIds($cast_id)
    {
        return $this->castMovieRepo::select("movie_details.*")
            ->join("movie_details","movie_details.id","casts_movies.movie_id")
            ->where("casts_movies.cast_id",$cast_id)
            ->get();
    }
}
