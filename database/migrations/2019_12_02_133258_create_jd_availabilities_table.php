<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJdAvailabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jd_availabilities', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('jd_id')->unsigned();
            $table->bigInteger('type')->unsigned()->nullable();
            $table->float('min')->default(0);
            $table->float('max')->default(0);
            $table->integer('importance')->default(0);

            $table->foreign('jd_id')->references('id')->on('jds')->onDelete('cascade');
            $table->foreign('type')->references('id')->on('availability_types')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jd_availabilities');
    }
}
