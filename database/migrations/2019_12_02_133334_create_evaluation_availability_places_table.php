<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationAvailabilityPlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_availability_places', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('place');
            $table->bigInteger('availability_id')->unsigned();

            $table->foreign('availability_id')->references('id')->on('evaluation_availabilities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluation_availability_places');
    }
}
