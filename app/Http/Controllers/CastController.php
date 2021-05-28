<?php

namespace App\Http\Controllers;

use App\Models\Cast;
use App\Models\MovieDetails;
use App\Repositories\CastRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use phpDocumentor\Reflection\Types\Callable_;
use PHPUnit\Util\Json;
use function MongoDB\BSON\toJSON;

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
     * @return Response
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
     * @return Response
     */
    public function store(Request $request)
    {
        return $this->castRepo->insertCastData($request);
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
     * @return Response
     */
    public function update(Request $request, Cast $cast,$id)
    {
        return $this->castRepo->updateCastData($request,$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Cast $cast
     * @return Response
     */
    public function destroy(Cast $cast,$id)
    {
        return $this->castRepo->deleteCastData($id);
    }

    public function getAllCasts(){
        return $this->castRepo->getAllCastData();
    }

    public function getCastDataById($id){
        return $this->castRepo->getCastDataById($id);
    }
}
