<?php

use Illuminate\Database\Seeder;

class CategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\ForumCategories::create([
            'title'       => 'OOPSIE WOOPSIE! We make a fucky wucky!!',
            'keyword'     => 'oopsie-woopsie',
            'description' => 'OOPSIE WOOPSIE!! Uwu We make a fucky wucky!! A wittle fucko boingo! The code monkeys at our headquarters are working VEWY HAWD to fix this!',
        ]);
    }
}
