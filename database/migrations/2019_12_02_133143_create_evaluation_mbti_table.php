<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationMbtiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_mbti', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('evaluation_id')->unsigned();
            $table->bigInteger('mbti_type')->unsigned();
            $table->integer('possibility')->default(0);
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
        Schema::dropIfExists('evaluation_mbti');
    }
}
