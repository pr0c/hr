<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJdPhysicalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jd_physical', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('jd_id')->unsigned();
            $table->integer('requirement')->default(0);
            $table->bigInteger('physical_type')->unsigned();
            $table->float('min')->nullable();
            $table->float('max')->nullable();

            $table->foreign('jd_id')->references('id')->on('jds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jd_physical');
    }
}
