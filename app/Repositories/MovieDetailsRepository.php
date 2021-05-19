<?php


namespace App\Repositories;


use App\Interfaces\MovieDetailsInterface;
use App\Models\MovieDetails;

class MovieDetailsRepository implements MovieDetailsInterface
{

    private $movieDetails;

    public function __construct(MovieDetails $movieDetails)
    {
        $this->movieDetails = $movieDetails;
    }

    public function all()
    {
        return $this->movieDetails::all();
    }

    public function save($data)
    {
       /* $this->movieDetails->title = $data["title"];
        $this->->user_id = $user_id;
        $this->blog->description = $data["description"];
        $this->blog->status = $data["status"];
        if ($this->blog->save()) {
            return $this->blog;
        } else {
            return false;
        }*/
    }

    public function getPaginate()
    {
        //return $this->user::join('blogs', 'blogs.user_id', '=', 'users.id')->where("status", "!=", "draft")->orderBy("blogs.created_at", "desc")->paginate(5);
    }

    public function getMovieById($movie_id)
    {
        // TODO: Implement getMovieById() method.
    }

    public function updateMovie($data, $movie_id)
    {
        // TODO: Implement updateMovie() method.
    }

    public function deleteMovie($movie_id)
    {
        return $this->movieDetails::where('id', $movie_id)->delete();
    }
}
