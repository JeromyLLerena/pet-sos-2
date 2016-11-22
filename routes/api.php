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
			Route::get('/', ['uses' => 'UserController@getUser', 'middleware' => 'jwt.auth']);
			Route::post('/update', ['uses' => 'UserController@update', 'middleware' => 'jwt.auth']);
		});
		Route::group(['prefix' => 'districts', 'namespace' => 'District'], function(){
			Route::get('/', ['uses' => 'DistrictController@all']);
		});
		Route::group(['prefix' => 'animals', 'namespace' => 'Animal'], function(){
			Route::get('/', ['uses' => 'AnimalController@all']);
		});
		Route::group(['prefix' => 'races', 'namespace' => 'Race'], function(){
			Route::get('/', ['uses' => 'RaceController@getRaces']);
		});
		Route::group(['prefix' => 'post_types', 'namespace' => 'PostType', 'middleware' => 'jwt.auth'], function(){
			Route::get('/', ['uses' => 'PostTypeController@all']);
		});
		Route::group(['prefix' => 'user_types', 'namespace' => 'UserType'], function(){
			Route::get('/', ['uses' => 'UserTypeController@all']);
		});
		Route::group(['prefix' => 'posts', 'namespace' => 'Post', 'middleware' => 'jwt.auth'], function(){
			Route::get('/', ['uses' => 'PostController@getApplicationPosts']);
			Route::post('/', ['uses' => 'PostController@create']);
			Route::get('/me', ['uses' => 'PostController@getUserPosts']);
			Route::get('/{post_id}/comments', ['uses' => 'PostController@getPostComments']);
		});

		Route::group(['prefix' => 'messages', 'namespace' => 'Message', 'middleware' => 'jwt.auth'], function(){
			Route::post('/', ['uses' => 'MessageController@sendMessage']);
			Route::get('/{root_id}', ['uses' => 'MessageController@getConversation']);
			Route::get('/', ['uses' => 'MessageController@getLastestMessages']);
		});

		Route::group(['prefix' => 'pets', 'namespace' => 'Pet', 'middleware' => 'jwt.auth'], function(){
			Route::post('/', ['uses' => 'PetController@create']);
			Route::get('/', ['uses' => 'PetController@getAllUserPets']);
		});

		Route::group(['prefix' => 'comments', 'namespace' => 'Comment', 'middleware' => 'jwt.auth'], function(){
			Route::post('/', ['uses' => 'CommentController@create']);
		});
	});
});


