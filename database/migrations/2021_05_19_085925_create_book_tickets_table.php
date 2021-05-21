<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("city_id");
            $table->unsignedBigInteger("theater_id");
            $table->unsignedBigInteger("movie_id");
            $table->string("show","5");
            $table->text("seats");
            $table->date("show_time_date");
            $table->timestamps();
            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("city_id")->references("id")->on("cities");
            $table->foreign("theater_id")->references("id")->on("theaters");
            $table->foreign("movie_id")->references("id")->on("movie_details");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_tickets');
    }
}
