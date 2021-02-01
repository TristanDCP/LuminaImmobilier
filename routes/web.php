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

        // Matches "/api/v1/user/delete/1" - Delete specific user
        $router->delete('user/delete/{idUser}', 'UserController@deleteUser');

        // Matches "/api/v1/property/create" - Create a Property
        $router->post('property/create', 'PropertyController@createProperty');

        // Matches "/api/v1/property/update/1" - Update Info on a property
        $router->put('property/update/{idProperty}', 'PropertyController@updateProperty');

        // Matches "/api/v1/property/delete/1" - Delete a property
        $router->delete('property/delete/{idProperty}', 'PropertyController@deleteProperty');

        // Matches "/api/v1/role/create" - Create a Role
        $router->post('role/create', 'RoleController@createRole');

        // Matches "/api/v1/roles" - Get all Roles
        $router->get('roles', 'RoleController@allRoles');

        // Matches "/api/v1/agency/create" - Create an Agency
        $router->post('agency/create', 'AgencyController@createAgency');

        // Matches "/api/v1/agency/update/1" - Update Info on an agency
        $router->put('agency/update/{idAgency}', 'AgencyController@updateAgency');

        // Matches "/api/v1/agency/delete/1" - Delete an agency
        $router->delete('agency/delete/{idAgency}', 'AgencyController@deleteAgency');

        // Matches "/api/v1/picture/create" - Create a Picture
        $router->post('picture/create', 'PictureController@createPicture');

        // Matches "/ap/v1/appointments" - Get all appointments
        $router->get('appointments', 'AppointmentController@allAppointment');

        // Matches "/api/v1/appointment/update/1" - Update Info on a Appointment
        $router->put('appointment/update/{idAppointment}', 'AppointmentController@updateAppointment');

        // Matches "/api/v1/appointment/delete/1" - Delete a Appointment
        $router->delete('appointment/delete/{idAppointment}', 'AppointmentController@deleteAppointment');
    });

    // Group where it need to be connected to use the routes
    $router->group(['auth' => App\Http\Middleware\Authenticate::class], function () use ($router) {

        // Matches "/api/v1/user/update/1" - Update info on specific user
        $router->put('user/update/{idUser}', 'UserController@updateUser');

        // Matches "/ap/v1/appointment/create" - Create an Appointment
        $router->post('appointment/create', 'AppointmentController@createAppointment');

        // Matches "/api/v1/appointment/1" - Get one appointment by id
        $router->get('appointment/{idAppointment}', 'AppointmentController@singleAppointment');
    });
});
