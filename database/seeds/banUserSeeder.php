<?php

use App\UserReport;
use App\User;
use App\UserInformation;
use Illuminate\Database\Seeder;

class banUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $max_user = User::count();
        for ($i = 1; $i <= $max_user; $i++)
        {
            $report_to_profile = mt_rand(1, $max_user);
            $user_information = UserInformation::userPermissions($i);
            if ($i !== $report_to_profile && !$user_information['admin'] && !$user_information['banned'])
            {
                UserReport::create([
                    'participant_id' => $report_to_profile,
                    'user_id' => $i,
                    'type' => 'profile',
                    'reason' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.'
                ]);
            }
        }
    }
}
