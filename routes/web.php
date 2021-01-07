<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// API route group
$router->group(['prefix' => 'api/v1/'], function () use ($router) {
    // Matches "/api/v1/register
    $router->post('register', 'AuthController@register');

    // Matches "/api/v1/login
    $router->post('login', 'AuthController@login');

    $router->group(['middleware' => App\Http\Middleware\AdminRoutes::class], function () use ($router) {

        // Matches "/api/v1/profile
        $router->get('profile', 'UserController@profile');

        // Matches "/api/v1/users
        $router->get('users', 'UserController@allUsers');

        // Matches "/api/v1/users/1 
        // get one user by id
        $router->get('users/{idUser}', 'UserController@singleUser');

        // get all property
        $router->get('property', 'PropertyController@allProperties');

        // get one property by id
        $router->get('property/{idProperty}', 'PropertyController@singleProperty');
    });
});
