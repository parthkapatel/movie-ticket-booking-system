<?php

namespace App\Http\Controllers;

use App\Models\BookTickets;
use App\Models\Cast;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class BookTicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view("index");
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
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request,User $user)
    {
        //dd(Auth::user()->id);
        $bookTicket = new BookTickets();
        $bookTicket->user_id = "";
        $bookTicket->city_id = $request->city_id;
        $bookTicket->theater_id = $request->theater_id;
        $bookTicket->movie_id = $request->movie_id;
        $bookTicket->show = $request->show;
        $bookTicket->seats = implode('|', $request->seats);
        $bookTicket->save();
        return $bookTicket;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BookTickets  $bookTickets
     * @return Response
     */
    public function show(BookTickets $bookTickets)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BookTickets  $bookTickets
     * @return Response
     */
    public function edit(BookTickets $bookTickets)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BookTickets  $bookTickets
     * @return Response
     */
    public function update(Request $request, BookTickets $bookTickets)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BookTickets  $bookTickets
     * @return Response
     */
    public function destroy(BookTickets $bookTickets)
    {
        //
    }

    //$city_id,$theater_id,$movie_id
    public function getBookedTickets(){
        return Cast::all();
    }


}
