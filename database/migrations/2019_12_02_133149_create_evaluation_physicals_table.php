<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationPhysicalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_physicals', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('measurement')->unsigned();
            $table->bigInteger('evaluation_id')->unsigned();
            $table->float('amount');
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
        Schema::dropIfExists('evaluation_physicals');
    }
}
