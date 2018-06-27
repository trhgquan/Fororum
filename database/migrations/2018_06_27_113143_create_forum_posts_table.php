<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateForumPostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('forum_posts', function(Blueprint $table)
		{
			$table->increments('post_id');
			$table->integer('parent_id')->default(0)->comment('= 0 means this is a thread, others is the parent thread\'s id');
			$table->integer('category_id')->default(0)->comment('= 0 mean this is a post. others is thread and this is the thread\'s category');
			$table->integer('user_id');
			$table->string('title', 100)->nullable()->comment('null nếu đây là 1 post');
			$table->text('content', 65535);
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('forum_posts');
	}

}
