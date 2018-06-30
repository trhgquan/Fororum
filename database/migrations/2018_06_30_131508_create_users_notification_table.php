<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersNotificationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_notification', function(Blueprint $table)
		{
			$table->integer('notify_id', true);
			$table->integer('user_id');
			$table->integer('participant_id');
			$table->string('route', 50);
			$table->text('content', 65535);
			$table->boolean('open')->default(0);
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
		Schema::drop('users_notification');
	}

}
