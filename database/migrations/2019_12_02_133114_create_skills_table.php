<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skills', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('skill_type')->unsigned();
            $table->float('years_exp')->nullable();
            $table->float('hours_exp')->nullable();
            $table->integer('ability')->default(0);
            $table->integer('potential_ability')->nullable();
            $table->integer('confidence')->nullable();
            $table->integer('interest')->nullable();

            $table->foreign('skill_type')->references('id')->on('skill_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skills');
    }
}
