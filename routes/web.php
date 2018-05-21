<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@home');
Route::get('/home', 'HomeController@home');

Route::prefix('/user')->group(function(){
	Route::get('/', function(){
		return redirect()->route('edit');
	});
	Route::get('/edit', 'ProfileController@edit')->name('edit');
	Route::get('/search', function(){
		return view('search', [
			'users' => 0
		]);
	})->middleware('auth');
	Route::get('/search/{keyword}', 'SearchController@SearchForUser')->name('searchForUser');
	Route::get('/profile', 'ProfileController@home');

	Route::get('/profile/{username}', 'ProfileController@profile')->where('username', '^[A-Za-z0-9._]+$')->name('profile');

	Route::post('/profile/{username}/follow', 'ProfileController@follow')->where('username', '^[A-Za-z0-9._]+$')->name('follow');

	Route::post('/edit', 'ProfileController@editPassword');

	Route::post('/search', function(){
		return redirect()->route('searchForUser', [
			'keyword' => request()->get('keyword')
		]);
	})->middleware('auth');
});

Route::prefix('/f')->group(function(){
	Route::get('/', 'ForumController@home')->name('forum');
	Route::get('/search', function(){
		return view('search', [
			'posts' => 0
		]);
	})->middleware('auth');
	Route::get('/search/{keyword}', 'SearchController@searchForPost')->name('searchPostWithKeyword');
	Route::post('/search', function (){
		return redirect()->route('searchPostWithKeyword', [
			'keyword' => request()->get('keyword')
		]);
	})->middleware('auth');
	Route::get('/{forum_category}', 'ForumController@category')->where('forum_category', '^[A-Za-z0-9-]+$')->name('category');
	Route::get('/t/{thread_id}', 'ForumController@thread')->where('thread_id','^[0-9]+$')->name('thread');
	Route::get('/p/{post_id}', 'ForumController@post')->where('post_id','^[0-9]+$')->name('post');
	Route::post('/create/post', 'ForumController@createPost')->middleware('auth', 'alive')->name('createPost');
	Route::post('/create/thread', 'ForumController@createThread')->middleware('auth','alive', 'confirmed')->name('createThread');
});

Route::get('/login', 'LoginController@home')->name('login');
Route::get('/logout', 'LoginController@logout')->name('logout');
Route::get('/register', 'RegisterController@home')->name('register');
Route::post('/login', 'LoginController@login');
Route::post('/register', 'RegisterController@register');
