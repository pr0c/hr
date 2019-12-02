<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJdMbtiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jd_mbti', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('jd_id')->unsigned();
            $table->bigInteger('mbti_type')->unsigned();
            $table->integer('possibility')->default(0);

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
        Schema::dropIfExists('jd_mbti');
    }
}
