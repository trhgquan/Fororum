<?php

use App\ForumPosts;
use Illuminate\Database\Seeder;

class ForumPostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ForumPosts::create([
        //     'parent_id' => 8,
        // 	// 'category_id' => 2,
        // 	'user_id' => 6,
        // 	'title' => 're: Syria donors fall short without U.S. aid, warn of cruel end-game',
        // 	'content' => 'Humanitarian agencies also pleaded for peace before the Syrian military and its Russian and Iranian backers turn their firepower on the rebel-controlled Syrian city of Idlib, warning of civilian suffering on a greater scale than during the siege of Aleppo last year.'
        // ]);
        App\ForumCategories::create([
            'title'       => 'Hàn Quốc',
            'keyword'     => 'han-quoc',
            'description' => 'lạnh vl',
        ]);
    }
}
