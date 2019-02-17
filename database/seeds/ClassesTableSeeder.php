<?php

use Illuminate\Database\Seeder;

class ClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('class_tables')->insert([

            'name' => '5J',
            'teacher_id' => 1,
            'about' => "I'm still learning"
        ]);
    }
}
