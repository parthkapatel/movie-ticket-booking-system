<?php


namespace App\Interfaces;


interface CityInterface
{
    public function save($data);

    public function update($data,$city_id);

    public function delete($city_id);

    public function getAllCity();

    public function getCityById($city_id);

    public function getCityByMovieId($movie_id);
}
