<?php


namespace App\Interfaces;

use App\Models\MovieDetails;
use Illuminate\Support\Collection;

interface MovieDetailsInterface
{

    public function save($data);

    public function update($data,$movie_id);

    public function delete($movie_id);

    public function getMovieById($movie_id);

    public function getAllMovies();

    public function getSearchMovie($str);
}
