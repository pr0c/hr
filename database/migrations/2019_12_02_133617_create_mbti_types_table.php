<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMbtiTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mbti_types', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->bigInteger('role_id')->unsigned();
            $table->bigInteger('verb_id')->unsigned();
            $table->bigInteger('seasonal_clock')->unsigned();
            $table->bigInteger('elemental')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mbti_types');
    }
}
