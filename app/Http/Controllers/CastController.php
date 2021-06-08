<?php

namespace App\Http\Controllers;

use App\Models\Cast;
use App\Repositories\CastRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CastController extends Controller
{

    private $castRepo;
    public function __construct(CastRepository $castRepository)
    {
        $this->castRepo = $castRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Response
     */
    public function index()
    {
        return view("welcome");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Cast
     */
    public function store(Request $request)
    {
        $request->validate([
            'cast_image' => 'required'
        ]);

        if($request->file()) {
            $file_name = time().'_'.$request->cast_image->getClientOriginalName();
            $file_upload = $request->file('cast_image')->move('assets/img/cast', $file_name);
            $file_path = "/assets/img/cast/" . $file_name;
            return $this->castRepo->save($request,$file_path);
        }else{
            return "please select image";
        }

    }

    /**
     * Display the specified resource.
     *
     * @param Cast $cast
     * @return Response
     */
    public function show(Cast $cast)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Cast $cast
     * @return Response
     */
    public function edit(Cast $cast,$id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Cast $cast
     * @param $id
     * @return Cast|Response|string
     */
    public function update(Request $request, Cast $cast,$id)
    {
        $request->validate([
            'cast_image' => 'required'
        ]);

        if($request->file()) {
            $file_name = time().'_'.$request->cast_image->getClientOriginalName();
            $file_upload = $request->file('cast_image')->move('assets/img/cast', $file_name);
            $file_path = "/assets/img/cast/" . $file_name;
            return $this->castRepo->update($request,$id,$file_path);
        }else{
            return "please select image";
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Cast $cast
     * @return Response
     */
    public function destroy(Cast $cast,$id)
    {
        return $this->castRepo->delete($id);
    }

    public function getAllCasts(){
        return $this->castRepo->getAllCastData();
    }

    public function getCastDataById($id){
        return $this->castRepo->getCastDataById($id);
    }
}
