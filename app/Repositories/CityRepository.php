<?php


namespace App\Repositories;


use App\Interfaces\CityInterface;
use App\Models\City;

class CityRepository implements CityInterface
{

    private $city;
    public function __construct(City $city)
    {
        $this->city = $city;
    }

    public function save($data)
    {
        $exisitingCity = $this->city::where("city_name", $data->city_name)->first();
        if ($exisitingCity) {
            return json_encode(["status" => "error", "message" => "City already exists!"]);
        } else {
            $this->city->city_name = $data->city_name;
            $this->city->save();
            return json_encode(["status"=>"success","message"=>"City Successfully Added"]);
        }
    }

    public function update($data, $city_id)
    {
        $childData =  $this->city::join("release_movies", "release_movies.city_id", "cities.id")->where("cities.id", $city_id)->get()->count();
        if ($childData > 0) {
            return json_encode(["status"=>"error","message"=>"you can not update this data after assign movie or theater"]);
        } else {
            $this->city =  $this->city::find($city_id);
            if ( $this->city) {
                $this->city->city_name = $data->city_name;
                $this->city->save();
                return json_encode(["status"=>"success","message"=>"City Successfully Updated"]);
            }
            return json_encode(["status"=>"error","message"=>"City Not Found"]);
        }
    }

    public function delete($city_id)
    {
        $childData =  $this->city::join("release_movies", "release_movies.city_id", "cities.id")->where("cities.id", $city_id)->get()->count();
        if ($childData > 0) {
            return json_encode(["status"=>"error","message"=>"you can not delete this data after assign movie or theater"]);
        } else {
            $this->city =  $this->city::find($city_id);
            if ( $this->city) {
                $this->city->delete();
                return json_encode(["status"=>"success","message"=>"City Successfully deleted"]);
            }
            return json_encode(["status"=>"error","message"=>"City Not Found"]);
        }
    }

    public function getAllCity()
    {
        return  $this->city::orderBy("city_name")->get();
    }

    public function getCityById($city_id)
    {
        return  $this->city::find($city_id);
    }
}
