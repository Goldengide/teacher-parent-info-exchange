<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_summaries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('class_id');
            $table->integer('subject_id');
            $table->integer('average_performance');
            $table->text('comment');
            $table->timestamps();
        });

        //class_summary = id, class_id, subject_id, average_performance
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('class_summaries');
    }
}
