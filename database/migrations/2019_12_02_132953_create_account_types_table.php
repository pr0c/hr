<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_types', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('title_id')->unsigned();
            $table->bigInteger('default_provider')->unsigned();
//            $table->foreign('title_id')->references('id')->on('texts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_types');
    }
}
