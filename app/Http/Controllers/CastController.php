<?php

namespace App\Http\Controllers;

use App\Models\Cast;
use App\Models\MovieDetails;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Callable_;
use PHPUnit\Util\Json;
use function MongoDB\BSON\toJSON;

class CastController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newCast = new Cast();
        $newCast->name = $request->name;
        $newCast->bio = $request->bio;
        $newCast->date_of_birth = $request->date_of_birth;
        $newCast->save();
        return $newCast;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cast  $cast
     * @return \Illuminate\Http\Response
     */
    public function show(Cast $cast)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cast  $cast
     * @return \Illuminate\Http\Response
     */
    public function edit(Cast $cast,$id)
    {
        return Cast::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cast  $cast
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cast $cast,$id)
    {
        $existingCast = Cast::find($id);
        if($existingCast){
            $existingCast->name = $request->name;
            $existingCast->bio = $request->bio;
            $existingCast->date_of_birth = $request->date_of_birth;
            $existingCast->save();
            return $existingCast;
        }
        return "Cast not found";

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cast  $cast
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cast $cast,$id)
    {
        $existingCast = Cast::find($id);
        if($existingCast){
            $existingCast->delete();
            return "Cast Successfully deleted";
        }
        return "Cast not found";
    }

    public function getALlCasts(){
        return Cast::orderBy("name")->get();
    }

}
