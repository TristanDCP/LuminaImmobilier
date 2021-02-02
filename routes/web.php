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

    // Matches "/ap/v1/properties" - Get all properties
    $router->get('properties', 'PropertyController@allProperties');

    // Matches "/api/v1/property/1" - Get one property by id
    $router->get('property/{idProperty}', 'PropertyController@singleProperty');

    // Matches "/api/v1/agencies" - Get all agencies
    $router->get('agencies', 'AgencyController@allAgency');

    // Matches "/api/v1/agency/1" - Get one agency by id
    $router->get('agency/{idAgency}', 'AgencyController@singleAgency');

    // Matches "/api/v1/pictures" - Get all Pictures
    $router->get('pictures', 'PictureController@allPictures');

    // Matches "/api/v1/picture/1" - Get specific Picture
    $router->get('picture/{idPicture}', 'PictureController@singlePicture');

    // Group where it need to be admin to use the routes
    $router->group(['middleware' => App\Http\Middleware\AdminRoutes::class], function () use ($router) {

        // Matches "/api/v1/profile" - Get profile of User
        $router->get('profile', 'UserController@profile');

        // Matches "/api/v1/users" - Get users list
        $router->get('users', 'UserController@allUsers');

        // Matches "/api/v1/user/1" - Get info on specific user
        $router->get('user/{idUser}', 'UserController@singleUser');

        // Matches "/api/v1/user/1" - Delete specific user
        $router->delete('user/{idUser}', 'UserController@deleteUser');

        // Matches "/api/v1/property" - Create a Property
        $router->post('property', 'PropertyController@createProperty');

        // Matches "/api/v1/property/1" - Update Info on a property
        $router->put('property/{idProperty}', 'PropertyController@updateProperty');

        // Matches "/api/v1/property/1" - Delete a property
        $router->delete('property/{idProperty}', 'PropertyController@deleteProperty');

        // Matches "/api/v1/role" - Create a Role
        $router->post('role', 'RoleController@createRole');

        // Matches "/api/v1/roles" - Get all Roles
        $router->get('roles', 'RoleController@allRoles');

        // Matches "/api/v1/agency" - Create an Agency
        $router->post('agency', 'AgencyController@createAgency');

        // Matches "/api/v1/agency/1" - Update Info on an agency
        $router->put('agency/{idAgency}', 'AgencyController@updateAgency');

        // Matches "/api/v1/agency/1" - Delete an agency
        $router->delete('agency/{idAgency}', 'AgencyController@deleteAgency');

        // Matches "/api/v1/picture" - Create a Picture
        $router->post('picture', 'PictureController@createPicture');

        // Matches "/ap/v1/appointments" - Get all appointments
        $router->get('appointments', 'AppointmentController@allAppointment');

        // Matches "/api/v1/appointment/1" - Update Info on a Appointment
        $router->put('appointment/{idAppointment}', 'AppointmentController@updateAppointment');

        // Matches "/api/v1/appointment/1" - Delete a Appointment
        $router->delete('appointment/{idAppointment}', 'AppointmentController@deleteAppointment');
    });

    // Group where it need to be connected to use the routes
    $router->group(['auth' => App\Http\Middleware\Authenticate::class], function () use ($router) {

        // Matches "/api/v1/user/1" - Update info on specific user
        $router->put('user/{idUser}', 'UserController@updateUser');

        // Matches "/ap/v1/appointment/create" - Create an Appointment
        $router->post('appointment', 'AppointmentController@createAppointment');

        // Matches "/api/v1/appointment/1" - Get one appointment by id
        $router->get('appointment/{idAppointment}', 'AppointmentController@singleAppointment');
    });
});
