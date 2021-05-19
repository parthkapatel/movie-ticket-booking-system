<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookTickets extends Model
{
    use HasFactory;

    protected $guard = 'bookTicket';

    protected $fillable = [
        'user_id', 'city_id', 'theater_id','movie_id','show','seats'
    ];
}
