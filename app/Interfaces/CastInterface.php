<?php


namespace App\Interfaces;

use App\Models\Cast;

interface CastInterface
{
    public function getAllCastData();

    public function insertCastData($data);

    public function updateCastData($data,$cast_id);

    public function deleteCastData($cast_id);

    public function getCastDataById($cast_id);

}
