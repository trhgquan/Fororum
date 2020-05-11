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
 * There are many routes in here. Be careful before edit anything.
 */
Route::group(['prefix' => '/dashboard', 'middleware' => ['fororum.admin'], 'as' => 'admin.'], function () {
    Route::get('/', function () {
        return view('admin.admin-template', ['action' => 'home']);
    })->name('home');

    // Manage
    Route::group(['prefix' => '/forum', 'as' => 'forum-manager.'], function () {
        Route::get('/', function () {
            return redirect()->route('admin.forum-manager.subforum');
        });

        // subforums
        Route::group(['prefix' => '/subforum', 'as' => 'subforum'], function () {
            Route::get('/', function () {
                return view('admin.admin-template', ['action' => 'subforum', 'role' => 'subforum']);
            });

            Route::post('/edit', 'AdminController@editSubforum')->name('.edit');
            Route::post('/create', 'AdminController@createSubforum')->name('.create');
        });

        Route::get('reports', function () {
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
 * Basic cheatsheet for a profile: http://example.com/profile/johndoe
 */
Route::group(['prefix' => '/profile', 'middleware' => ['auth', 'fororum.alive'], 'as' => 'profile.'], function () {
    Route::get('/', function () {
        return redirect()->route('profile.user', [Auth::user()->username]);
    })->name('home');

    Route::get('/edit', function () {
        return redirect()->route('profile.edit');
    });

    Route::group(['prefix' => '/{username}', 'where' => ['username' => '^[A-Za-z0-9._]+$'], 'as' => 'user'], function () {
        Route::get('/', 'ProfileController@profile');
        Route::post('/follow', 'ProfileController@follow')->name('.follow');
    });

    Route::get('/edit', 'ProfileController@edit')->name('edit');
    Route::post('/edit/password', 'ProfileController@editPassword')->name('edit.password');
});

/*
 * Notification route
 * Notice that there are many methods in here, be careful.
 */
Route::group(['prefix' => '/notify', 'as' => 'notify.', 'middleware' => ['auth', 'fororum.alive']], function () {
    Route::get('/', function () {
        return view('notify', ['user' => Auth::user()]);
    })->name('home');
    Route::group(['prefix' => '/read', 'as' => 'read.'], function () {
        Route::get('/all', function () {
            (App\User::find(Auth::id()))->unreadNotifications->markAsRead();

            return redirect()->route('notify.home');
        })->name('all');
    });
    Route::group(['prefix' => '/delete', 'as' => 'delete.'], function () {
        Route::get('/all', function () {
            (App\User::find(Auth::id()))->notifications()->delete();

            return redirect()->route('notify.home');
        })->name('all');
    });
});

/*
 * Search route
 * Search for profile: http://example.com/search/profile/loremipsum
 * Search for post   : http://example.com/search/post/loremipsum
 */
Route::group(['prefix' => '/search', 'middleware' => ['auth', 'fororum.alive'], 'as' => 'search'], function () {
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
Route::group(['prefix' => '/report', 'middleware' => ['auth', 'fororum.alive'], 'as' => 'report.'], function () {
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
    Route::post('/create/post', 'ForumController@createPost')->middleware('auth', 'fororum.alive', 'verified')->name('createPost');
    Route::post('/create/thread', 'ForumController@createThread')->middleware('auth', 'fororum.alive', 'verified')->name('createThread');
});

/*
 * Authentication route
 * basic cheatsheet:
 * Login page : http://example.com/login    GET
 * Register   : http://example.com/register GET
 * Logout     : http://example.com/logout   POST
 */
Route::name('auth.')->group(function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/login', function () {
            return view('auth.login');
        })->name('login');

        Route::get('/register', function () {
            return view('auth.register');
        })->name('register');

        Route::post('/login', 'LoginController@login');

        Route::post('/register', 'RegisterController@register');
    });

    Route::post('/logout', 'LoginController@logout')->middleware('auth')->name('logout');
});

/**
 * Home Route
 * Example: http://example.com/ or http://example.com/home.
 */
Route::group(['prefix' => '/', 'middleware' => 'fororum.alive'], function () {
    Route::get('/', function () {
        return view('home');
    });

    Route::get('/home', function () {
        return view('home');
    });
});

/**
 * Verify Email Address route
 * This is for both GET and POST request.
 */
Route::group(['prefix' => '/email', 'as' => 'verification.'], function () {
    Route::get('/', function () {
        return redirect()->route('verification.notice');
    });

    Route::get('/verify', 'VerificationController@show')->name('notice');

    Route::get('/verify/{id}', 'VerificationController@verify')->name('verify');

    Route::get('/resend', 'VerificationController@resend')->name('resend');
});

/**
 * Recover account route
 * This is for both GET and POST request.
 */
Route::group(['prefix' => '/recover', 'middleware' => 'guest', 'as' => 'recover'], function () {
    Route::get('/', function () {
        return view('recover');
    });

    Route::get('/{username}/{token}', function ($username, $token) {
        return dd($username, $token);
    })->name('.confirm');

    Route::post('/', 'LoginController@recoverRequest')->name('.requestToken');
});
