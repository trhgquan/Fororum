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
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'email'    => 'admin@example.com',
        ]);
    }
}
