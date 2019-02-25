<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('parent_name');
            $table->string('img_url')->default('profile.jpg');
            $table->integer('parent_id')->default(0);
            $table->integer('class_id');
            $table->integer('entry_class_id');
            $table->integer('entry_season_id');
            $table->integer('exit_season_id')->default(0);
            $table->tinyInteger('graduated')->default(0);
            $table->string('profile_pics');
            $table->string('birthday');
            $table->string('gender');
            $table->string('likes')->nullable();
            $table->string('dislikes')->nullable();
            $table->string('habits')->nullable();
            $table->string('student_name');
            $table->string('phone');
            $table->string('phone2');
            $table->string('email');
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
        Schema::drop('students');
    }
}
