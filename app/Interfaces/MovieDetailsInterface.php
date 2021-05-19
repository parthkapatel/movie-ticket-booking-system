<?php


namespace App\Interfaces;

use App\Models\MovieDetails;
use Illuminate\Support\Collection;

interface MovieDetailsInterface
{
    public function all();

    public function save($data);

    public function getPaginate();

    public function getMovieById($movie_id);

    public function updateMovie($data, $movie_id);

    public function deleteMovie($movie_id);

}
