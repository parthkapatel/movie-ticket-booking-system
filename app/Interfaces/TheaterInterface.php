<?php


namespace App\Interfaces;


interface TheaterInterface
{
    public function save($data);

    public function update($data,$theater_id);

    public function delete($theater_id);

    public function getTheaterById($theater_id);

    public function getAllTheaters();

    public function getAllTheaterByCityId($theater_id);
}
