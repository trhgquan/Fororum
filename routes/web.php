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

// if there are something needs to be tested with route,
// write it below, before the Admin route.
// TODO: always check if the test route is deleted.

/**
 * Admin route.
 */
Route::group(['prefix' => '/dashboard', 'middleware' => ['auth', 'admin', 'alive'], 'as' => 'admin.'], function () {
    Route::get('/', function () {
        return view('admin.admin-template', ['action' => 'home']);
    })->name('home');

    // Manage
    Route::group(['prefix' => '/manage', 'as' => 'manage.'], function () {
        Route::get('/', function () {
            return redirect()->route('admin.home');
        });

        // subforums
        Route::group(['prefix' => '/subforum', 'as' => 'subforum'], function () {
            Route::get('/', function () {
                return view('admin.admin-template', ['action' => 'subforum', 'role' => 'subforum']);
            });

            Route::post('/edit', 'AdminController@editSubforum')->name('.edit');
            Route::post('/create', 'AdminController@createSubforum')->name('.create');
        });

        Route::get('report/post', function () {
            return view('admin.admin-template', ['action' => 'management', 'role' => 'post']);
        })->name('post');
    });

    // profiles management
    Route::group(['prefix' => '/profiles', 'as' => 'profiles-manager'], function () {
        // this return all the active users.
        Route::get('/', function () {
            return view('admin.admin-template', [
                'action'    => 'editUser',
                'users_raw' => App\UserInformation::getActiveUsers(),
            ]);
        })->name('.home');

        // display all the reports
        Route::get('/reports', function () {
            return view('admin.admin-template', ['action' => 'management', 'role' => 'user']);
        })->name('.reports');

        // da search engine.
        // something like http://example.com/dashboard/profile/loremipsum
        Route::get('/{keyword}', function ($keyword) {
            if (!empty(App\User::search($keyword)->total() > 0)) {
                return view('admin.admin-template', [
                    'action'    => 'editUser',
                    'keyword'   => $keyword,
                    'users_raw' => App\User::search($keyword),
                ]);
            }

            return redirect()->route('admin.profiles-manager.home')->withErrors(['class' => 'warning', 'content' => 'Không tìm thấy người dùng này!']);
        })->name('.search.result');

        // search for a specific user.
        Route::post('/search', 'SearchController@adminSearchEngine')->name('.search');

        // edit user information
        Route::post('/edit', 'AdminController@editUserInformation')->name('.edit');

        // review user reports.
        Route::post('/takedown', 'AdminController@reviewUserReport')->name('.takedown');
    });
});

/*
 * User (Profile, Edit Profile) route
 */
Route::group(['prefix' => '/user', 'middleware' => ['auth', 'alive'], 'as' => 'user.'], function () {
    Route::get('/', function () {
        return redirect()->route('user.edit');
    });
    Route::group(['prefix' => '/profile', 'as' => 'profile.'], function () {
        Route::get('/', function () {
            return redirect()->route('user.profile.username', [Auth::user()->username]);
        })->name('home');
        Route::group(['prefix' => '/{username}', 'where' => ['username' => '^[A-Za-z0-9._]+$'], 'as' => 'username'], function () {
            Route::get('/', 'ProfileController@profile');
            Route::post('/follow', 'ProfileController@follow')->name('.follow');
        });
    });
    Route::get('/edit', 'ProfileController@edit')->name('edit');
    Route::post('/edit/password', 'ProfileController@editPassword')->name('edit.password');
});

/*
 * Notification route
 */
Route::group(['prefix' => '/notify', 'as' => 'notify.', 'middleware' => ['auth', 'alive']], function () {
    Route::get('/', function () {
        return view('notify');
    })->name('home');
    Route::get('/{notify_id}', 'NotifyController@notify')->where('notify_id', '^[0-9]+$')->name('notifies');
});

/*
 * Search route
 * Search for profile: http://example.com/search/profile/loremipsum
 * Search for post   : http://example.com/search/post/loremipsum
 */
Route::group(['prefix' => '/search', 'middleware' => ['auth', 'alive'], 'as' => 'search'], function () {
    Route::get('/', function () {
        return view('search', ['have_results' => false]);
    })->name('.home');
    Route::get('/{action}/{keyword}', 'SearchController@search');
    Route::post('/search', 'SearchController@searchWithKeyword')->name('.keyword');
});

/*
 * Report route
 * Report a profile : http://example.com/report/profile/johndoe
 * Report a post    : http://example.com/report/post/1
 */
Route::group(['prefix' => '/report', 'middleware' => ['auth', 'alive'], 'as' => 'report.'], function () {
    Route::get('/profile/{username}', 'ReportController@profile')->where('username', '^[A-Za-z0-9._]+$')->name('profile');
    Route::get('/post/{post_id}', 'ReportController@post')->where('post_id', '^[0-9]+$')->name('post');
    Route::post('/', 'ReportController@handle')->name('handle');
});

/*
 * Forum route
 * basic cheatsheet for a forum url:
 * a category : http://example.com/forum/1 | http://example.com/forum/lorem-ipsum
 * a thread: http://example.com/forum/thread/thread-1.html
 * a post  : http://example.com/forum/post/post-1.html
 *
 * cannot use the group middleware here, because the forum is free-to-use.
 * customize to private registered-only, add the group middleware.
 */
Route::prefix('/forum')->group(function () {
    Route::get('/', 'ForumController@home')->name('forum');
    Route::get('/{forum_category}', 'ForumController@category')->where('forum_category', '^[A-Za-z0-9.-]+$')->name('category');
    Route::get('/thread/thread-{thread_id}.html', 'ForumController@thread')->where('thread_id', '^[0-9]+$')->name('thread');
    Route::get('/post/post-{post_id}.html', 'ForumController@post')->where('post_id', '^[0-9]+$')->name('post');
    Route::post('/create/post', 'ForumController@createPost')->middleware('auth', 'alive')->name('createPost');
    Route::post('/create/thread', 'ForumController@createThread')->middleware('auth', 'alive', 'confirmed')->name('createThread');
});

// Home
Route::get('/', 'HomeController@home');

Route::get('/home', 'HomeController@home');

// Register
Route::get('/register', function () {
    return view('register');
})->middleware('guest')->name('register');

Route::post('/register', 'RegisterController@register');

// Login
Route::get('/login', function () {
    return view('login');
})->middleware('guest')->name('login');

Route::post('/login', 'LoginController@login');

Route::post('/logout', 'LoginController@logout')->name('logout');
