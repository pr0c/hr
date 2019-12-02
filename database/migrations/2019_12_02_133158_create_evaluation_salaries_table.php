<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_salaries', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('last_currency')->unsigned()->nullable();
            $table->bigInteger('new_currency')->unsigned()->nullable();
            $table->integer('perspective')->nullable();
            $table->integer('last_hours')->nullable();
            $table->decimal('last_salary', 6, 2)->nullable();
            $table->decimal('last_extras', 6, 2)->nullable();
            $table->decimal('new_salary', 6, 2)->nullable();
            $table->decimal('new_extras', 6, 2)->nullable();
            $table->integer('new_hours')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluation_salaries');
    }
}
