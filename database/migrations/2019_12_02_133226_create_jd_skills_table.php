<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJdSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jd_skills', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('jd_id')->unsigned();
            $table->bigInteger('skill_id')->unsigned();
            $table->integer('importance')->default(0);

            $table->foreign('jd_id')->references('id')->on('jds')->onDelete('cascade');
            $table->foreign('skill_id')->references('id')->on('skills')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jd_skills');
    }
}
