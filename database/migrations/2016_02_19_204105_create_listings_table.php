<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
	    $table->increments('id');
            $table->string('street_address');
            $table->string('city');
            $table->string('state');
            $table->string('postal');
            $table->string('country');
            $table->string('listprice');
            $table->string('listingurl');
            $table->string('bedrooms');
            $table->string('bathrooms');
            $table->string('propertytype');
	    $table->string('listingkey');
            $table->string('listingcategory');
            $table->string('listingstatus');
            $table->string('discloseaddress');
            $table->string('listingdescription');
            $table->string('mlsid');
            $table->string('mlsname');
            $table->string('mlsnumber');
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
        Schema::drop('listings');
    }
}
