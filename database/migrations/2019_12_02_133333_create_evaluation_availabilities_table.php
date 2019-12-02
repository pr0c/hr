<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationAvailabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_availabilities', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('evaluation_id')->unsigned();
            $table->bigInteger('type')->unsigned();
            $table->float('min')->nullable();
            $table->float('max')->nullable();

            $table->foreign('evaluation_id')->references('id')->on('evaluations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluation_availabilities');
    }
}
