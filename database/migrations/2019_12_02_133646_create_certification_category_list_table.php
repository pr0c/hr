<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificationCategoryListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certification_category_list', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('certification_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();

            $table->foreign('certification_id')->references('id')->on('certifications')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('certification_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('certification_category_list');
    }
}
