<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationJobSuitabilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_job_suitability', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('evaluation_id')->unsigned();
            $table->bigInteger('job_title_id')->unsigned()->nullable();
            $table->float('years_exp')->nullable();
            $table->float('hour_salary')->nullable();
            $table->bigInteger('currency')->unsigned()->nullable();
            $table->integer('ability')->default(0);
            $table->integer('potential_ability')->default(0);
            $table->integer('confidence')->default(0);
            $table->integer('interest')->default(0);
            $table->foreign('evaluation_id')->references('id')->on('evaluations')->onDelete('cascade');
            $table->foreign('job_title_id')->references('id')->on('job_titles')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluation_job_suitability');
    }
}
