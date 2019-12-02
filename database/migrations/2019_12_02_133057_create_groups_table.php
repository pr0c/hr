<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('short_name')->nullable();
            $table->string('full_name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->bigInteger('country')->unsigned()->nullable();
            $table->string('vat')->nullable();
            $table->integer('reg_number')->nullable();
            $table->string('website')->nullable();
            $table->bigInteger('owner_id')->unsigned()->nullable();
            $table->string('owner_type')->nullable();
            $table->bigInteger('logo')->unsigned()->default(0);
            $table->bigInteger('type')->nullable();
            $table->foreign('country')->references('id')->on('countries')->onDelete('set null');
//            $table->foreign('logo')->references('id')->on('attachments')->onDelete('set default');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
    }
}
