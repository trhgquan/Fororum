<?php

use Illuminate\Database\Seeder;

class NotificationSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\UserNotification::create([
            'user_id' => 1,
            'participant_id' => 7,
            'content' => App\User::username(7) . ' đã tạo 1 chủ đề mới trong Triều Tiên.',
        ]);
    }
}
