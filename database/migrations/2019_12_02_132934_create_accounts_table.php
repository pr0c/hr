<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('type');
            $table->string('identifier');
            $table->bigInteger('provider')->unsigned()->nullable();
            $table->bigInteger('owner_id')->unsigned()->nullable();
            $table->string('owner_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
