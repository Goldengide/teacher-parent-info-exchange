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
            'other_role' => 'engineer',
            'password' => bcrypt('gideon'),
            'email' => 'amowogbajegideon@gmail.com',
            'phone' => '08174007780',

        ]);

        
        \DB::table('users')->insert([

            'firstname' => 'Gideon',
            'lastname' => 'Amowogbaje',
            'othernames' => 'Amowogbaje',
            'username' => 'Gideon. A',
            'role' => 'admin',
            'password' => bcrypt('itismyseason1988'),
            'email' => 'admin@gmail.com',
            'phone' => '08174007781',

        ]);
    }
}
