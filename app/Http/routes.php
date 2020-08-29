<?php

// Home //
Route::get('/', [
	'uses' => '\socialmpt\Http\Controllers\HomeController@index',
	'as' => 'home',
]);

// Auth //

// sup
 Route::get('/signup', [
 	'uses' => '\socialmpt\Http\Controllers\AuthController@getSignup',
 	'as' => 'auth.signup',
 	'middleware' => ['guest'],
 ]);

  Route::post('/signup', [
 	'uses' => '\socialmpt\Http\Controllers\AuthController@postSignup',
 	'middleware' => ['guest'],
 ]);


// sin
   Route::get('/signin', [
 	'uses' => '\socialmpt\Http\Controllers\AuthController@getSignin',
 	'as' => 'auth.signin',
 	'middleware' => ['guest'],
 ]);

  Route::post('/signin', [
 	'uses' => '\socialmpt\Http\Controllers\AuthController@postSignin',
 	'middleware' => ['guest'],
 ]);


 //sout
     Route::get('/signout', [
 	'uses' => '\socialmpt\Http\Controllers\AuthController@getSignout',
 	'as' => 'auth.signout',
 ]);


// Search //

Route::get('/search', [
	'uses' => '\socialmpt\Http\Controllers\SearchController@getResults',
	'as' => 'search.results',
]);


// Profile //

Route::get('/user/{username}', [
	'uses' => '\socialmpt\Http\Controllers\ProfileController@getProfile',
	'as' => 'profile.index',
]);

Route::get('/profile/edit', [
	'uses' => '\socialmpt\Http\Controllers\ProfileController@getEdit',
	'as' => 'profile.edit',
	'middleware' => ['auth'],
]);

Route::post('/profile/edit', [
	'uses' => '\socialmpt\Http\Controllers\ProfileController@postEdit',
	'middleware' => ['auth'],
]);


// Friends //

Route::get('/friends', [
	'uses' => '\socialmpt\Http\Controllers\FriendController@getIndex',
	'as' => 'friend.index',
	'middleware' => ['auth'],
]);


Route::get('/friends/add/{username}', [
	'uses' => '\socialmpt\Http\Controllers\FriendController@getAdd',
	'as' => 'friend.add',
	'middleware' => ['auth'],
]);

Route::get('/friends/accept/{username}', [
	'uses' => '\socialmpt\Http\Controllers\FriendController@getAccept',
	'as' => 'friend.accept',
	'middleware' => ['auth'],
]);

Route::post('/friends/delete/{username}', [
	'uses' => '\socialmpt\Http\Controllers\FriendController@postDelete',
	'as' => 'friend.delete',
	'middleware' => ['auth'],
]);

// Statuses //

Route::post('/status', [
	'uses' => '\socialmpt\Http\Controllers\StatusController@postStatus',
	'as' => 'status.post',
	'middleware' => ['auth'],
]);

Route::post('/status/{statusId}/reply', [
	'uses' => '\socialmpt\Http\Controllers\StatusController@postReply',
	'as' => 'status.reply',
	'middleware' => ['auth'],
]);

Route::get('/status/{statusId}/like', [
	'uses' => '\socialmpt\Http\Controllers\StatusController@getLike',
	'as' => 'status.like',
	'middleware' => ['auth'],
]);

Route::get('/status/{statusId}/delete', [
	'uses' => '\socialmpt\Http\Controllers\StatusController@getDelete',
	'as' => 'status.delete',
	'middleware' => ['auth'],
]);