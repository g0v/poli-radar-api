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
		$api->get('politicians', 'PoliticiansController@index');
		$api->get('politicians/{id}', 'PoliticiansController@show');
		$api->get('politicianCategories', 'PoliticianCategoryController@index');
		$api->get('politicianCategories/names', 'PoliticianCategoryController@withNames');
		$api->get('politicianCategories/{id}', 'PoliticianCategoryController@show');
		$api->get('cities', 'CityController@index');
		$api->get('cities/{id}', 'CityController@show');
		$api->get('locations', 'LocationController@index');
		$api->get('regions', 'RegionController@index');
		$api->get('viewer', 'ViewerController@index');
		$api->get('viewer/{hash}', 'ViewerController@show');
		$api->post('viewer', 'ViewerController@store');
		$api->put('viewer/{hash}', 'ViewerController@update');

		// All routes in here are protected and thus need a valid token
		$api->group( [ 'middleware' => ['jwt.auth'] ], function ($api) {

			$api->get('users/me', 'AuthController@me');
			$api->get('users/permissions', 'AuthController@permissions');
			$api->get('validate_token', 'AuthController@validateToken');

			$api->post('events', 'EventsController@store');
			$api->post('events/batch', 'EventsController@batchStore');
			$api->put('events/{id}', 'EventsController@update');

			$api->group(['middleware' => ['role:admin']], function($api) {
				$api->get('users', 'AuthController@index');
				$api->post('users', 'AuthController@store');
				$api->get('roles', 'RoleController@index');
				$api->get('permissions', 'PermissionController@index');
				$api->post('politicians', 'PoliticiansController@store');
				$api->put('politicians/{id}', 'PoliticiansController@update');
				$api->post('politicianCategories', 'PoliticianCategoryController@store');
			});

		});

	});

});

// Version 2 of our API
$api->version('v2', function ($api) {

	// Set our namespace for the underlying routes
	$api->group(['namespace' => 'Api\V2\Controllers', 'middleware' => 'cors'], function ($api) {

		$api->post('auth/login', 'AuthController@login');
		$api->post('auth/signup', 'AuthController@signup');

		$api->get('politician_categories', 'PoliticianCategoryController@index');
		$api->get('politician_categories/{id}', 'PoliticianCategoryController@show');

		$api->get('locations', 'LocationController@index');
		$api->get('locations/{id}', 'LocationController@show');

		$api->get('events', 'EventsController@index');

		// All routes in here are protected and thus need a valid token
		$api->group( [ 'middleware' => ['jwt.auth'] ], function ($api) {
			$api->get('validate_token', 'AuthController@validateToken');

			$api->post('locations', 'LocationController@store');
			$api->post('politicians/{id}/events', 'PoliticianEventController@store');
		});
	});
});
