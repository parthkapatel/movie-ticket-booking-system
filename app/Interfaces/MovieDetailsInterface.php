<?php


namespace App\Interfaces;

use App\Models\MovieDetails;
use Illuminate\Support\Collection;

interface MovieDetailsInterface
{

    public function save($data,$file_path);

    public function update($movie_id,$data,$file_path);

    public function delete($movie_id);

    public function getMovieById($movie_id);

    public function getAllMovies();

    public function getSearchMovie($str);
}
