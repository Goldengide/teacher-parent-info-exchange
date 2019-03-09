<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id');
            $table->integer('season_id');
            $table->integer('class_id');
            $table->integer('teacher_id');
            $table->integer('subject_id');
            $table->integer('assessment');
            $table->integer('exam_score');
            $table->integer('total');
            $table->tinyInteger('approved');
            $table->tinyInteger('processed');
            $table->integer('times_uploaded');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('results');
    }
}
