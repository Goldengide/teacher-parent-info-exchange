<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_summaries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('class_id');
            $table->integer('student_id');
            $table->integer('season_id');
            $table->integer('percentage');
            $table->string('best_score');
            $table->string('worse_score');
            $table->string('comments');
            $table->timestamps();
        });
    }


    // student_summary = id, student_id, season, percentage, best_subject, worse_subject, comments
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('student_summaries');
    }
}
