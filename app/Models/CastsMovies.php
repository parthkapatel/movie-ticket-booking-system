<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CastsMovies extends Model
{
    use HasFactory;

    protected $fillable = [
        'cast_id',
        'movie_id',
    ];
}
