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
        // App\User::create([
        // 	'username' => 'trhgquan',
        // 	'password' => bcrypt('0753815536'),
        // 	'email'    => 'tranhoangq@gmail.com'
        // // ]);

        $totalUser = App\User::count();
        $destination = 6;
        for ($i=1; $i <= $totalUser; $i++)
        {
            if ($i !== $destination)
            {
                App\UserFollowers::create([
                    'user_id' => $i,
                    'participant_id' => $destination
                ]);
            }
        }
    }
}
