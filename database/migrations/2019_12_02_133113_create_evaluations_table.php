<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluations', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('moment')->nullable();
            $table->bigInteger('evaluator')->unsigned()->nullable();
            $table->bigInteger('method')->unsigned()->nullable();
            $table->bigInteger('person')->unsigned();
            $table->bigInteger('public_notes')->unsigned()->nullable();
            $table->bigInteger('private_notes')->unsigned()->nullable();
            $table->bigInteger('attachments')->unsigned()->nullable();
            $table->bigInteger('salary')->unsigned()->nullable();

            $table->foreign('evaluator')->references('id')->on('persons')->onDelete('set null');
            //$table->foreign('salary')->references('id')->on('evaluation_salaries')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluations');
    }
}
