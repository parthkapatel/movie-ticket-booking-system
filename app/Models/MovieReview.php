<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieReview extends Model
{
    use HasFactory;

    protected $fillable = [ 'review'];

    protected $primaryKey = 'id';

    public function movieReview()
    {
        return $this->hasMany(MovieReview::class,"movie_id");
    }



}
