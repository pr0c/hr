<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJdBenefitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jd_benefits', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('jd_id')->unsigned();
            $table->integer('week_days')->nullable();
            $table->bigInteger('benefit')->unsigned();
            $table->string('frequency')->default('');
            $table->bigInteger('availability')->unsigned()->nullable();
            $table->boolean('private')->default(true);

            $table->foreign('jd_id')->references('id')->on('jds')->onDelete('cascade');
            $table->foreign('benefit')->references('id')->on('benefits')->onDelete('cascade');
            $table->foreign('availability')->references('id')->on('benefit_availabilities')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jd_benefits');
    }
}
