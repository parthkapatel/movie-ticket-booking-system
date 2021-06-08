<?php


namespace App\Interfaces;

interface CastInterface
{
    public function save($data,$file_path);

    public function update($data,$cast_id,$file_path);

    public function delete($cast_id);

    public function getCastDataById($cast_id);

    public function getAllCastData();

}
