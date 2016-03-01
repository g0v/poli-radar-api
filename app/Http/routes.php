<?php

Route::get('oauth/google', 'App\Http\Controllers\Auth\AuthController@redirectToProvider');
Route::get('login/google', 'App\Http\Controllers\Auth\AuthController@handleProviderCallback');

$api = app('Dingo\Api\Routing\Router');

// Version 1 of our API
$api->version('v1', function ($api) {

	// Set our namespace for the underlying routes
	$api->group(['namespace' => 'Api\Controllers', 'middleware' => 'cors'], function ($api) {

		// Login route
		$api->post('login', 'AuthController@authenticate');
		$api->post('register', 'AuthController@register');

		$api->get('data', 'AllDataController@index');
		$api->get('events', 'EventsController@index');
		$api->get('candidates', 'CandidatesController@index');

		// All routes in here are protected and thus need a valid token
		$api->group( [ 'middleware' => ['jwt.auth', 'jwt.refresh'] ], function ($api) {

			$api->get('users/me', 'AuthController@me');
			$api->get('validate_token', 'AuthController@validateToken');

		});

	});

});
