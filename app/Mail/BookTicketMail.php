<?php

namespace App\Mail;

use App\Models\BookTickets;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookTicketMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $ticket_id;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ticket_id)
    {
        $this->ticket_id = $ticket_id;
    }

    public function build(): BookTicketMail
    {
        $data =  BookTickets::select('users.name as name','cities.city_name','theaters.theater_name','movie_details.title','book_tickets.show','book_tickets.seats','book_tickets.created_at','book_tickets.id',"book_tickets.show_time_date")
            ->join("users","users.id","book_tickets.user_id")
            ->join("cities","cities.id","book_tickets.city_id")
            ->join("theaters","theaters.id","book_tickets.theater_id")
            ->join("movie_details","movie_details.id","book_tickets.movie_id")
            ->where("book_tickets.id",$this->ticket_id)
            ->get();
        $data = $data[0];
        return $this->from('parth9427@gmail.com')
            ->view('mails.bookedTicket')->with([
                "data"=>$data
            ]);
    }
}
