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
        dd(Auth::user());
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
    public function destroy(BookTickets $bookTickets,$id)
    {
        $existingTicket =  BookTickets::find($id);
        if($existingTicket)
        {
            $existingTicket->delete();
            return $existingTicket;
        }
        return "Book Ticket Not Found";

    }
    public function getAllBookedTicketsByUserId(){
        //dd(Auth::user());
        return BookTickets::select('users.name','cities.city_name','theaters.theater_name','movie_details.title','book_tickets.show','book_tickets.seats','book_tickets.created_at','book_tickets.id',"book_tickets.show_time_date")
            ->join("users","users.id","book_tickets.user_id")
            ->join("cities","cities.id","book_tickets.city_id")
            ->join("theaters","theaters.id","book_tickets.theater_id")
            ->join("movie_details","movie_details.id","book_tickets.movie_id")
            ->where("book_tickets.user_id",2)
            ->orderBy("book_tickets.show_time_date","desc")
            ->get();
    }

    public function getAllUserBookedTickets(){
        return BookTickets::select('users.name','cities.city_name','theaters.theater_name','movie_details.title','book_tickets.show','book_tickets.seats','book_tickets.created_at','book_tickets.id',"book_tickets.show_time_date")
            ->join("users","users.id","book_tickets.user_id")
            ->join("cities","cities.id","book_tickets.city_id")
            ->join("theaters","theaters.id","book_tickets.theater_id")
            ->join("movie_details","movie_details.id","book_tickets.movie_id")
            ->orderBy("book_tickets.created_at","desc")
            ->get();
    }

    public function getAllBookedSeats(Request $request){
        return BookTickets::select('book_tickets.seats','book_tickets.city_id','book_tickets.theater_id','book_tickets.movie_id')
            ->where("book_tickets.city_id",$request->city_id)
            ->where("book_tickets.theater_id",$request->theater_id)
            ->where("book_tickets.movie_id",$request->movie_id)
            ->where("book_tickets.show",'LIKE',"%{$request->show}%")
            ->get();
    }


}
