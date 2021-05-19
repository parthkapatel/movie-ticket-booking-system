<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReleaseMovies extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'theater_id',
        'movie_id',
        'runtime',
    ];
}
