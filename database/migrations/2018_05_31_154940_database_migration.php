<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DatabaseMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $users){
            $users->increments('id');
            $users->string('username', 255)->unique();
            $users->string('email', 255)->unique();
            $users->string('password', 255);
            $users->string('remember_token', 100);
            $users->timestamps();
        });

        Schema::create('users_information', function (Blueprint $uinfo){
            $uinfo->increments('id');
            $uinfo->boolean('confirmed')->default(0);
            $uinfo->boolean('permissions')->default(1);
            $uinfo->timestamps();
        });

        Schema::create('users_followers', function (Blueprint $followers){
            $followers->increments('id');
            $followers->integer('user_id');
            $followers->integer('participant_id');
            $followers->timestamps();
        });

        Schema::create('users_notification', function (Blueprint $notification) {
            $notification->increments('notify_id');
            $notification->integer('user_id');
            $notification->integer('participant_id');
            $notification->string('route', 10);
            $notification->text('content');
            $notification->boolean('open')->default(0);
            $notification->timestamps();
        });

        Schema::create('forum_categories', function (Blueprint $forum_categories){
            $forum_categories->increments('id');
            $forum_categories->string('keyword', 40);
            $forum_categories->string('title', 40);
            $forum_categories->text('description');
            $forum_categories->timestamps();
        });

        Schema::create('forum_posts', function (Blueprint $forum_posts){
            $forum_posts->increments('post_id');
            $forum_posts->integer('parent_id')->default(0)->comment('= 0 if this is a thread');
            $forum_posts->integer('category_id')->default(0)->comment('= 0 if this is a post');
            $forum_posts->integer('user_id');
            $forum_posts->string('title', 100)->nullable();
            $forum_posts->text('content');
            $forum_posts->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
