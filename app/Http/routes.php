<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/**
 * AngularJS frontend routes
 */

$angularSpaAction = 'MainController@spa';

// common users
Route::get('signin', $angularSpaAction);
Route::get('signup', $angularSpaAction);
Route::get('password_reset', $angularSpaAction);
Route::get('/', $angularSpaAction);

// managers
Route::get('users', $angularSpaAction);

// admins
Route::get('user_meals/{user}', $angularSpaAction);


/**
 * REST API routes
 */

Route::group(['prefix' => 'api/v1', 'namespace' => 'Api'], function () {
    // Auth routes
    Route::post('signin', 'AuthController@signIn');
    Route::post('signup', 'AuthController@signUp');
    Route::match(
        ['put', 'patch'], 'password_reset', 'AuthController@resetPass'
    );

    // User meals CRUD routes
    Route::get('user_meals/{user}', 'UserMealsController@index');
    Route::post('user_meals/{user}', 'UserMealsController@store');
    Route::match(
        ['put', 'patch'],
        'user_meals/{user}/{id}',
        'UserMealsController@update');
    Route::delete('user_meals/{user}/{id}', 'UserMealsController@destroy');

    // Users CRUD routes
    Route::get('users', 'UsersController@index');
    Route::get('users/{user}', 'UsersController@show');
    Route::post('users', 'UsersController@store');
    Route::match(['put', 'patch'], 'users/{user}', 'UsersController@update');
    Route::delete('users/{user}', 'UsersController@destroy');
    Route::match(['put', 'patch'], 'users/change_password/{user}',
        'UsersController@changePassword');
});
