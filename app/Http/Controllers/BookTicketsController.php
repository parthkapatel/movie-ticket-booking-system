<?php

namespace App\Http\Controllers;

use App\Models\BookTickets;
use App\Mail\BookTicketMail;
use App\Models\User;
use App\Repositories\BookTicketsRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BookTicketsController extends Controller
{

    private $bookedRepo;
    public function __construct(BookTicketsRepository $bookTicketsRepository)
    {
        $this->bookedRepo = $bookTicketsRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
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
     * @return BookTickets
     */
    public function store(Request $request,User $user)
    {
        return $this->bookedRepo->save($request);
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
     * @param Request $request
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
        return $this->bookedRepo->delete($id);
    }

    public function getAllBookedTicketsByUserId(){
        return $this->bookedRepo->getAllBookedTicketsByUserId();
    }

    public function getAllUserBookedTickets(){
        return $this->bookedRepo->getAllUserBookedTickets();
    }

    public function getAllBookedSeats(Request $request){
        if($request->time == ''){
            $date = date("Y-m-d", strtotime(Carbon::now()));
        }else{
            $date = $request->time;
        }
        return $this->bookedRepo->getAllBookedSeats($request,$date);
    }
}
