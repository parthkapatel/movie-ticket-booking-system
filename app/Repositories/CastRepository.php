<?php


namespace App\Repositories;


use App\Interfaces\CastInterface;
use App\Models\Cast;
use phpDocumentor\Reflection\Types\This;

class CastRepository implements CastInterface
{

    private $cast;
    public function __construct(Cast $cast)
    {
        $this->cast = $cast;
    }

    public function getAllCastData()
    {
        return $this->cast::orderBy("name")->get();
    }

    public function save($data)
    {
        $this->cast->name = $data->name;
        $this->cast->bio = $data->bio;
        $this->cast->date_of_birth = $data->date_of_birth;
        $this->cast->save();
        return $this->cast;
    }


    public function update($data, $cast_id)
    {
        $this->cast::find($cast_id);
        if($this->cast){
            $this->cast->name = $data->name;
            $this->cast->bio = $data->bio;
            $this->cast->date_of_birth = $data->date_of_birth;
            $this->cast->save();
            return $this->cast;
        }
        return "Cast not found";
    }

    public function delete($cast_id)
    {
        $this->cast::find($cast_id);
        if($this->cast){
            $this->cast->delete();
            return "Cast Successfully deleted";
        }
        return "Cast not found";
    }

    public function getCastDataById($cast_id)
    {
        return $this->cast::find($cast_id);
    }
}
