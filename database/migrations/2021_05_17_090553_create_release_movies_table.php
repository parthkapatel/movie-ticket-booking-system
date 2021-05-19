<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReleaseMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('release_movies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("city_id");
            $table->unsignedBigInteger("theater_id");
            $table->unsignedBigInteger("movie_id");
            $table->text("runtime");
            $table->timestamps();
            $table->foreign("city_id")->references("id")->on("cities")->onDelete('cascade');
            $table->foreign("theater_id")->references("id")->on("theaters")->onDelete('cascade');
            $table->foreign("movie_id")->references("id")->on("movie_details")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('release_movies');
    }
}
