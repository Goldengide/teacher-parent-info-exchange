<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('users')->insert([

            'firstname' => 'Gideon',
            'lastname' => 'Amowogbaje',
            'othernames' => 'Amowogbaje',
            'username' => 'Gideon. A',
            'role' => 'admin',
            'password' => bcrypt('gideon'),
            'email' => 'amowogbajegideon@gmail.com',
            'phone' => '08174007780',

        ]);
    }
}
