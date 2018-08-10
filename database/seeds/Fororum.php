<?php

use Illuminate\Database\Seeder;

class Fororum extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create the admin account.
        // you can change both the username and password later.
        $user = App\User::create([
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'email'    => 'admin@example.com',
        ]);

        // the code above just created an account.
        // now we make that account admin.
        App\UserInformation::create([
            'id'          => $user->id,
            'confirmed'   => 1,
            'permissions' => 2,
        ]);

        // create the first category in the forum.
        // you can also delete it or make changes on it later.
        App\ForumCategories::create([
            'title'       => 'OOPSIE WOOPSIE! We make a fucky wucky!!',
            'keyword'     => 'oopsie-woopsie',
            'description' => 'OOPSIE WOOPSIE!! Uwu We make a fucky wucky!! A wittle fucko boingo! The code monkeys at our headquarters are working VEWY HAWD to fix this!',
        ]);
    }
}
