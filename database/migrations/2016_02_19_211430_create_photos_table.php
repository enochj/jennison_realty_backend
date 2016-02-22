<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */


    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->increments('id');
	    $table->string('listing_id');
	    $table->foreign('listing_id')->references('id')->on('listings')
		->onDelete('cascade')
		->onUpdate('cascade');
            $table->string('mediamodificationtimestamp');
            $table->string('mediaurl');
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
        Schema::drop('photos');
    }
}
