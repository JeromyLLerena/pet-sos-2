<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function (){
	return 'API';
});

Route::group(['namespace' => 'Api'], function(){
	Route::group(['prefix' => 'v1', 'namespace' => 'V1'], function(){
		Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function(){
			Route::post('/', ['uses' => 'AuthController@postLogin']);
		});
		Route::group(['prefix' => 'users', 'namespace' => 'User'], function(){
			Route::post('/', ['uses' => 'UserController@create']);
		});
		Route::group(['prefix' => 'districts', 'namespace' => 'District', 'middleware' => 'jwt.auth'], function(){
			Route::get('/', ['uses' => 'DistrictController@all']);
		});
		Route::group(['prefix' => 'animals', 'namespace' => 'Animal', 'middleware' => 'jwt.auth'], function(){
			Route::get('/', ['uses' => 'AnimalController@all']);
		});
		Route::group(['prefix' => 'races', 'namespace' => 'Race', 'middleware' => 'jwt.auth'], function(){
			Route::get('/', ['uses' => 'RaceController@all']);
		});
		Route::group(['prefix' => 'post_types', 'namespace' => 'PostType', 'middleware' => 'jwt.auth'], function(){
			Route::get('/', ['uses' => 'PostTypeController@all']);
		});
		Route::group(['prefix' => 'user_types', 'namespace' => 'UserType', 'middleware' => 'jwt.auth'], function(){
			Route::get('/', ['uses' => 'UserTypeController@all']);
		});
		Route::group(['prefix' => 'posts', 'namespace' => 'Post', 'middleware' => 'jwt.auth'], function(){
			Route::get('/', ['uses' => 'PostController@all']);
			Route::post('/', ['uses' => 'PostController@create']);
			Route::get('/me', ['uses' => 'PostController@getUserPosts']);
		});

		Route::group(['prefix' => 'messages', 'namespace' => 'Message', 'middleware' => 'jwt.auth'], function(){
			Route::post('/', ['uses' => 'MessageController@sendMessage']);
			Route::get('/{another_user_id}', ['uses' => 'MessageController@getConversation']);
			Route::get('/', ['uses' => 'MessageController@getLastestMessages']);
		});
	});
});


