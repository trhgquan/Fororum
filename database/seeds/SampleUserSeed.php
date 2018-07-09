<?php

use Illuminate\Database\Seeder;

class SampleUserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
        	'username' => 'trhgquan',
        	'password' => bcrypt('0753815536'),
        	'email'    => 'tranhoangq@gmail.com'
        ]);
    }
}
