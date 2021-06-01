<?php


namespace App\Interfaces;


interface BookTicketsInterface
{
    public function save($data);

    public function update($data,$booked_id);

    public function delete($booked_id);

    public function getAllBookedTicketsByUserId();

    public function getAllUserBookedTickets();

    public function getAllBookedSeats($data,$date);
}
