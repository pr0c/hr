<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeJobHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_history', function(Blueprint $table) {
            $table->dropForeign(['job_description_id']);
            $table->dropColumn('job_description_id');
            $table->string('job_description');
            $table->dropForeign(['job_title_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
