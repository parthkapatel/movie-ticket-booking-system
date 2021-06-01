<?php


namespace App\Interfaces;

interface CastInterface
{
    public function save($data);

    public function update($data,$cast_id);

    public function delete($cast_id);

    public function getCastDataById($cast_id);

    public function getAllCastData();

}
