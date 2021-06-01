<?php


namespace App\Interfaces;


interface CastMoviesInterface
{
    public function save($data);

    public function update($data,$castMovie_id);

    public function delete($castMovie_id);

    public function getCastMovieById($castMovie_id);

    public function getAllCastMovies();

    public function getAllCastMoviesByMovieIds($movie_id);

    public function getAllCastMoviesByCastIds($cast_id);
}
