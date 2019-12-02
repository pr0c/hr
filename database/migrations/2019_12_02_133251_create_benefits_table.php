<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBenefitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('benefits', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('type')->unsigned();
            $table->bigInteger('title_id')->unsigned();

            $table->foreign('type')->references('id')->on('benefit_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('benefits');
    }
}
