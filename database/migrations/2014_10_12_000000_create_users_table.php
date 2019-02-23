<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('fullname')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('othernames')->nullable();
            $table->string('username')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('phone2')->nullable();
            $table->string('role')->nullable();
            $table->string('other_role')->nullable();
            $table->integer('class_id')->nullable();
            $table->string('status')->nullable();
            $table->integer('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('birthdate')->nullable();
            $table->string('home_address')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
