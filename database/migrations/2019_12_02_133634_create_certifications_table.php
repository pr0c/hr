<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certifications', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('category')->unsigned()->nullable();
            $table->bigInteger('title_id')->unsigned();
            $table->bigInteger('attachments')->unsigned();
            $table->bigInteger('owner_id')->unsigned()->nullable();
            $table->string('owner_type')->nullable();

            $table->foreign('category')->references('id')->on('certification_types')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('certifications');
    }
}
