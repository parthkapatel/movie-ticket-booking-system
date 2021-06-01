<?php


namespace App\Interfaces;


interface ReleaseMovieInterface
{
    public function save($data);

    public function update($data,$releaseMovie_id);

    public function delete($releaseMovie_id);

    public function show($id);

    public function getReleaseMovieById($releaseMovie_id);

    public function getAllAssignMovies();

    public function getMoviesForHome();

    public function getAllShowByCityAndTheaterIds($city_id,$theater_id,$movie_id);

}
