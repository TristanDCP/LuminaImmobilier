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

    // Matches "/api/v1/register" - Registering
    $router->post('register', 'AuthController@register');

    // Matches "/api/v1/login" - Login
    $router->post('login', 'AuthController@login');

    // Matches "/ap/v1/property" - Get all properties
    $router->get('property', 'PropertyController@allProperties');

    // Matches "/api/v1/property/1" - Get one property by id
    $router->get('property/{idProperty}', 'PropertyController@singleProperty');

    // Matches "/ap/v1/agency" - Get all agencies
    $router->get('agency', 'AgencyController@allAgency');

    // Matches "/api/v1/agency/1" - Get one agency by id
    $router->get('agency/{idAgency}', 'AgencyController@singleAgency');

    // Matches "/ap/v1/appointments" - Get all appointments
    $router->get('appointments', 'AppointmentController@allAppointment');

    // Matches "/api/v1/appointment/1" - Get one appointment by id
    $router->get('appointment/{idAppointment}', 'AppointmentController@singleAppointment');

    // Matches "/ap/v1/appointment/create" - Create an Appointment
    $router->post('appointment/create', 'AppointmentController@createAppointment');

    // Matches "/ap/v1/roles" - Get all properties
    $router->get('roles', 'RoleController@allRoles');

    $router->group(['middleware' => App\Http\Middleware\AdminRoutes::class], function () use ($router) {

        // Matches "/api/v1/profile" - Get profile of User
        $router->get('profile', 'UserController@profile');

        // Matches "/api/v1/users" - Get users list
        $router->get('users', 'UserController@allUsers');

        // Matches "/api/v1/users/1" - Get info on specific user
        $router->get('users/{idUser}', 'UserController@singleUser');

        // Matches "/ap/v1/property/create" - Create a Property
        $router->post('property/create', 'PropertyController@createProperty');

        // Matches "/ap/v1/role/create" - Create a Role
        $router->post('role/create', 'RoleController@createRole');

        // Matches "/ap/v1/agency/create" - Create an Agency
        $router->post('agency/create', 'AgencyController@createAgency');
    });
});
