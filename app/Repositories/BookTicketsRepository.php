<?php


namespace App\Repositories;


use App\Interfaces\BookTicketsInterface;
use App\Mail\BookTicketMail;
use App\Mail\CancelTicketMail;
use App\Models\BookTickets;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BookTicketsRepository implements BookTicketsInterface
{
    private $bookTicket;
    public function __construct(BookTickets $bookTicket)
    {
        $this->bookTicket = $bookTicket;
    }

    public function save($data)
    {
        $this->bookTicket = new $this->bookTicket();
        $this->bookTicket->user_id = Auth::user()->id;
        $this->bookTicket->city_id = $data->city_id;
        $this->bookTicket->theater_id = $data->theater_id;
        $this->bookTicket->movie_id = $data->movie_id;
        $this->bookTicket->show = $data->show;
        $this->bookTicket->show_time_date = $data->show_time_date;
        $this->bookTicket->seats = implode('|', $data->seats);
        $this->bookTicket->save();
        Mail::to(Auth::user()->email)->send(new BookTicketMail($this->bookTicket->id));
        return $this->bookTicket;
    }

    public function update($data, $booked_id)
    {
        // TODO: Implement update() method.
    }

    public function delete($booked_id)
    {
        $data = $this->bookTicket::find($booked_id)->get();
        if($this->bookTicket::destroy($booked_id)){
            Mail::to(Auth::user()->email)->send(new CancelTicketMail($data));
            return "Booked Tickets Successfully deleted";
        }
        return "Booked Tickets Not Found";
    }

    public function getAllBookedTicketsByUserId()
    {
        return $this->bookTicket::select('users.name','cities.city_name','theaters.theater_name','movie_details.title','book_tickets.show','book_tickets.seats','book_tickets.created_at','book_tickets.id',"book_tickets.show_time_date")
            ->join("users","users.id","book_tickets.user_id")
            ->join("cities","cities.id","book_tickets.city_id")
            ->join("theaters","theaters.id","book_tickets.theater_id")
            ->join("movie_details","movie_details.id","book_tickets.movie_id")
            ->where("book_tickets.user_id",Auth::user()->id)
            ->orderBy("book_tickets.show_time_date","desc")
            ->get();
    }

    public function getAllUserBookedTickets()
    {
        return $this->bookTicket::select('users.name','cities.city_name','theaters.theater_name','movie_details.title','book_tickets.show','book_tickets.seats','book_tickets.created_at','book_tickets.id',"book_tickets.show_time_date")
            ->join("users","users.id","book_tickets.user_id")
            ->join("cities","cities.id","book_tickets.city_id")
            ->join("theaters","theaters.id","book_tickets.theater_id")
            ->join("movie_details","movie_details.id","book_tickets.movie_id")
            ->orderBy("book_tickets.created_at","desc")
            ->get();
    }

    public function getAllBookedSeats($data,$date)
    {
        return $this->bookTicket::select('book_tickets.seats','book_tickets.city_id','book_tickets.theater_id','book_tickets.movie_id')
            ->where("book_tickets.city_id",$data->city_id)
            ->where("book_tickets.theater_id",$data->theater_id)
            ->where("book_tickets.movie_id",$data->movie_id)
            ->where("book_tickets.show",'LIKE',"%{$data->show}%")
            ->where("book_tickets.show_time_date",$date)
            ->get();
    }
}
