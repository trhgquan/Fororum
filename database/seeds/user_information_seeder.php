<?php

use Illuminate\Database\Seeder;
use App\User;
use App\UserInformation;

class user_information_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $totalUser = User::count();

        for ($i=1; $i <= $totalUser; $i++) {
            UserInformation::create([
                'permissions' => 1,
            ]);
        }
    }
}
