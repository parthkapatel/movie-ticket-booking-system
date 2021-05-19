<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCastsMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('casts_movies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("cast_id");
            $table->unsignedBigInteger("movie_id");
            $table->foreign("cast_id")->references("id")->on("casts");
            $table->foreign("movie_id")->references("id")->on("movie_details");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('casts_movies');
    }
}
