<?php


namespace App\Repositories;


use App\Interfaces\MovieReviewInterface;
use App\Models\MovieDetails;
use App\Models\MovieReview;

class MovieReviewRepository implements MovieReviewInterface
{
    private $movieReview;
    public function __construct(MovieReview $movieReview)
    {
        $this->movieReview = $movieReview;
    }

    public function insertMovieReview($userId, $movieId, $review)
    {
        $this->movieReview->user_id = $userId;
        $this->movieReview->movie_id = $movieId;
        $this->movieReview->review = $review;
        $this->movieReview->save();
        return json_encode(["status"=>"success","message"=>"Movie review post successfully"]);
    }

    public function updateMovieReview($reviewId, $userId, $movieId, $review)
    {
        // TODO: Implement updateMovieReview() method.
    }

    public function getAllReviewByMovieId($movieId)
    {
        return MovieReview::select("movie_reviews.*","users.name")
            ->join("users","users.id","movie_reviews.user_id")
            ->where("movie_id",$movieId)
            ->orderBy("created_at","desc")
            ->get();
        //return MovieReview::find($movieId)->movieReview;
    }

    public function getAllReviewByUserId($userId)
    {
        // TODO: Implement getAllReviewByUserId() method.
    }

    public function deleteReview($userId)
    {
        // TODO: Implement deleteReview() method.
    }
}
