<?php


namespace App\Interfaces;


interface MovieReviewInterface
{
    public function insertMovieReview($userId,$movieId,$review);

    public function updateMovieReview($reviewId,$userId,$movieId,$review);

    public function getAllReviewByMovieId($movieId);

    public function getAllReviewByUserId($userId);

    public function deleteReview($userId);
}
