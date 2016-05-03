<?php
/*
Route::get('oauth/google', 'App\Http\Controllers\Auth\AuthController@redirectToProvider');
Route::get('oauth/google/callback', 'App\Http\Controllers\Auth\AuthController@handleProviderCallback');
*/
$api = app('Dingo\Api\Routing\Router');

// Version 1 of our API
$api->version('v1', function ($api) {

	// Set our namespace for the underlying routes
	$api->group(['namespace' => 'Api\Controllers', 'middleware' => 'cors'], function ($api) {

		// Login route
		$api->post('login', 'AuthController@authenticate');
		$api->post('register', 'AuthController@register');

		$api->get('data', 'AllDataController@index');
		$api->get('date', 'DateController@index');
		$api->get('events', 'EventsController@index');
		$api->get('events/{id}', 'EventsController@show');
		$api->get('events/{start?}/{end?}', 'EventsController@date');
		$api->get('politicians', 'PoliticiansController@index');
		$api->get('politicians/{id}', 'PoliticiansController@show');
		$api->get('politicianCategories', 'PoliticianCategoryController@index');
		$api->get('politicianCategories/{id}', 'PoliticianCategoryController@show');
		$api->get('cities', 'CityController@index');
		$api->get('locations', 'LocationController@index');
		$api->get('regions', 'RegionController@index');
		$api->get('viewer', 'ViewerController@index');
		$api->get('viewer/{uuid}', 'ViewerController@show');
		$api->post('viewer', 'ViewerController@store');

		// All routes in here are protected and thus need a valid token
		$api->group( [ 'middleware' => ['jwt.auth'] ], function ($api) {

			$api->get('users/me', 'AuthController@me');
			$api->get('validate_token', 'AuthController@validateToken');

			$api->post('events', 'ActivitiesController@store');
		});

	});

});
