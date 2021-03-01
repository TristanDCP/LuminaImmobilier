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

    // Créer un compte
    // Matches "/api/v1/register" - Registering
    $router->post('register', 'AuthController@register');

    // Se connecter
    // Matches "/api/v1/login" - Login
    $router->post('login', 'AuthController@login');

    // Voir tous les biens
    // Matches "/api/v1/properties" - Get all properties
    $router->get('properties', 'PropertyController@allProperties');

    // Voir un bien
    // Matches "/api/v1/property/1" - Get one property by id
    $router->get('property/{idProperty}', 'PropertyController@singleProperty');

    // Voir une pièce
    // Matches "/api/v1/property/1/1" - Get one piece by id
    $router->get('property/{idProperty}/{idPiece}', 'PieceController@singlePiece');

    // Voir une image
    // Matches "/api/v1/property/1/1/1" - Get one picture by id
    $router->get('property/{idProperty}/{idPiece}/{idPicture}', 'PictureController@singlePicture');

    // Voir toutes les agences 
    // Matches "/api/v1/agencies" - Get all agencies
    $router->get('agencies', 'AgencyController@allAgency');

    // Voir une agence via l'ID
    // Matches "/api/v1/agency/1" - Get one agency by id
    $router->get('agency/{idAgency}', 'AgencyController@singleAgency');

    // Matches "/api/v1/parameters" - Get all parameters
    $router->get('parameters', 'ParameterController@allParameters');

    // Matches "/api/v1/parameter/1" - Get one parameter by id
    $router->get('parameter/{idParameter}', 'ParameterController@singleParameter');


    // Group where it need to be connected to use the routes
    $router->group(['middleware' => App\Http\Middleware\Authenticate::class], function () use ($router) {

        // Accéder à son profil
        // Matches "/api/v1/user/1" - Get info on specific user
        $router->get('user/{idUser}', 'UserController@singleUser');

        // Supprimer son compte
        // Matches "/api/v1/user/1" - Delete specific user
        $router->delete('user/{idUser}', 'UserController@deleteUser');

        // Update son profil
        // Matches "/api/v1/user/1" - Update info on specific user
        $router->put('user/{idUser}', 'UserController@updateUser');

        // Créer un RDV
        // Matches "/api/v1/appointment/create" - Create an Appointment
        $router->post('appointment', 'AppointmentController@createAppointment');

        // Voir l'information d'un RDV
        // Matches "/api/v1/appointment/1" - Get one appointment by id
        $router->get('appointment/{idAppointment}', 'AppointmentController@singleAppointment');

        // Créer un document
        // Matches "/api/v1/document" - Create a document
        $router->post('document', 'DocumentController@createDocument');

        // Mettre à jour un document
        // Matches "/api/v1/document/1" - Update a document
        $router->put('document/{idDocument}', 'DocumentController@updateDocument');

        // Supprimer un document
        // Matches "/api/v1/document/1" - Delete a document
        $router->delete('document/{idDocument}', 'DocumentController@deleteDocument');

        // Voir un document
        // Matches "/api/v1/document/1" - Get a single document
        $router->get('document/{idDocument}', 'DocumentController@singleDocument');

        // Voir tous les documents
        // Matches "/api/v1/documents" - Get all documents
        $router->get('documents', 'DocumentController@allDocuments');

        
            // Group where it need to be admin to use the routes
            $router->group(['middleware' => App\Http\Middleware\AdminRoutes::class], function () use ($router) {

                // Récupérer la liste de tous les utilisateurs
                // Matches "/api/v1/users" - Get users list
                $router->get('users', 'UserController@allUsers');

                // Créer une propriété à vendre/louer
                // Matches "/api/v1/property" - Create a Property
                $router->post('property', 'PropertyController@createProperty');

                // Modifier les informations de la propriétés
                // Matches "/api/v1/property/1" - Update Info on a property
                $router->put('property/{idProperty}', 'PropertyController@updateProperty');

                // Suppression de propriété
                // Matches "/api/v1/property/1" - Delete a property
                $router->delete('property/{idProperty}', 'PropertyController@deleteProperty');

                // Créer une pièce
                // Matches "/api/v1/property/1" - Create a piece
                $router->post('property/{idProperty}', 'PieceController@createPiece');

                // Modifier les informations d'une pièce
                // Matches "/api/v1/property/1/1" - Update info on a piece
                $router->put('property/{idProperty}/{idPiece}', 'PieceController@updatePiece');

                // Supprimer une pièce
                // Matches "/api/v1/property/1/1" - Delete a piece
                $router->delete('property/{idProperty}/{idPiece}', 'PieceController@deletePiece');
                
                // Création d'une image
                // Matches "/api/v1/property/1/1" - Create a picture
                $router->post('property/{idProperty}/{idPiece}', 'PictureController@createPicture');

                // Supprimer une image
                // Matches "/api/v1/property/1/1/1" - Delete info on a picture
                $router->delete('property/{idProperty}/{idPiece}/{idPicture}', 'PictureController@deletePicture');

                // Créer un role
                // Matches "/api/v1/role" - Create a Role
                $router->post('role', 'RoleController@createRole');

                // Récupérer la liste des roles
                // Matches "/api/v1/roles" - Get all Roles
                $router->get('roles', 'RoleController@allRoles');

                // Créer une agence
                // Matches "/api/v1/agency" - Create an Agency
                $router->post('agency', 'AgencyController@createAgency');

                // Changer les informations d'une agence
                // Matches "/api/v1/agency/1" - Update Info on an agency
                $router->put('agency/{idAgency}', 'AgencyController@updateAgency');

                // Suppression d'une agence
                // Matches "/api/v1/agency/1" - Delete an agency
                $router->delete('agency/{idAgency}', 'AgencyController@deleteAgency');

                // Récupérer la liste de tous les rendez vous.
                // Matches "/api/v1/appointments" - Get all appointments
                $router->get('appointments', 'AppointmentController@allAppointment');

                // Modifier le rendez vous
                // Matches "/api/v1/appointment/1" - Update Info on a Appointment
                $router->put('appointment/{idAppointment}', 'AppointmentController@updateAppointment');

                // Supprimer un RDV
                // Matches "/api/v1/appointment/1" - Delete a Appointment
                $router->delete('appointment/{idAppointment}', 'AppointmentController@deleteAppointment');
            }); 
        });
    });


