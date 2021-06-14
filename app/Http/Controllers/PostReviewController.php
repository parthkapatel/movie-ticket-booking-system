<?php

namespace App\Http\Controllers;

use App\Models\MovieReview;
use App\Repositories\MovieReviewRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostReviewController extends Controller
{
    private $movieReviewRepo;
    public function __construct(MovieReviewRepository $movieReviewRepository)
    {
        $this->movieReviewRepo = $movieReviewRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param Request $request
     * @return false|string
     */
    public function store(Request $request)
    {
        return $this->movieReviewRepo->insertMovieReview(Auth::user()->id,$request->movieId,$request->review);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MovieReview  $postReview
     * @return \Illuminate\Http\Response
     */
    public function show(MovieReview $postReview)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MovieReview  $postReview
     * @return \Illuminate\Http\Response
     */
    public function edit(MovieReview $postReview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Models\MovieReview  $postReview
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MovieReview $postReview)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MovieReview  $postReview
     * @return \Illuminate\Http\Response
     */
    public function destroy(MovieReview $postReview)
    {
        //
    }

    public function getAllReviewByMovieId($mid){
        return $this->movieReviewRepo->getAllReviewByMovieId($mid);
    }
}
