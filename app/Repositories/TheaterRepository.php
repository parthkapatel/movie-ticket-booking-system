<?php


namespace App\Repositories;


use App\Interfaces\TheaterInterface;
use App\Models\Theater;

class TheaterRepository implements TheaterInterface
{

    private $theaterRepo;
    public function __construct(Theater $theater)
    {
        $this->theaterRepo = $theater;
    }

    public function save($data)
    {
        $exisitingCity =  $this->theaterRepo::where("theater_name", $data->theater_name)->first();
        if ($exisitingCity) {
            return json_encode(["status" => "error", "message" => "Theater already exists!"]);
        } else {
            $this->theaterRepo->theater_name = $data->theater_name;
            $this->theaterRepo->save();
            return json_encode(["status"=>"success","message"=>"Theater Successfully Added"]);
        }
    }

    public function update($data, $theater_id)
    {
        $childData =  $this->theaterRepo::join("release_movies", "release_movies.theater_id", "theaters.id")->where("theaters.id", $theater_id)->get()->count();
        if ($childData > 0) {
            return json_encode(["status"=>"error","message"=>"you can not update this data after assign movie"]);
        } else {
            $this->theaterRepo =  $this->theaterRepo::find($theater_id);
            if( $this->theaterRepo){
                $this->theaterRepo->theater_name = $data->theater_name;
                $this->theaterRepo->save();
                return json_encode(["status"=>"success","message"=>"Theater Successfully Updated"]);
            }
            return json_encode(["status"=>"error","message"=>"Theater Not Found"]);
        }
    }

    public function delete($theater_id)
    {
        $childData =  $this->theaterRepo::join("release_movies", "release_movies.theater_id", "theaters.id")->where("theaters.id", $theater_id)->get()->count();
        if ($childData > 0) {
            return json_encode(["status"=>"error","message"=>"you can not delete this data after assign movie"]);
        } else {
            if($this->theaterRepo::destroy($theater_id)){
                return json_encode(["status"=>"success","message"=>"Theater Successfully deleted"]);
            }
            return json_encode(["status"=>"error","message"=>"Theater Not Found"]);
        }
    }

    public function getTheaterById($theater_id)
    {
        return  $this->theaterRepo::find($theater_id);
    }

    public function getAllTheaters()
    {
        return  $this->theaterRepo::orderBy("theater_name")->get();
    }

    public function getAllTheaterByCityId($theater_id)
    {
        return $this->theaterRepo::select("theaters.*")
            ->join("release_movies","release_movies.theater_id","theaters.id")
            ->where("release_movies.city_id",$theater_id)
            ->where("release_movies.status","=","release")
            ->distinct()
            ->get();
    }
}
