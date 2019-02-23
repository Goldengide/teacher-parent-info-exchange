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
            $table->integer('parent_id')->default(0);
            $table->integer('class_id');
            $table->string('entry_class');
            $table->string('profile_pics');
            $table->string('birthday');
            $table->string('likes');
            $table->string('dislikes');
            $table->string('habits');
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
