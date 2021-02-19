<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

    /**
     * @OA\Parameter(
     *   parameter="get_users_request_parameter_limit",
     *   name="limit",
     *   description="Limit the number of results",
     *   in="query",
     *   @OA\Schema(
     *     type="number", default=10
     *   )
     * ),
     *
     * @OA\Parameter(
     *   parameter="get_user_id",
     *   name="idUser",
     *   description="Replace the user id",
     *   in="path",
     *   @OA\Schema(
     *     type="integer", default=1
     *   )
     * ),
     * 
     * @OA\Schema(
     *   schema="UserSchema",
     *   title="User Model",
     *   description="User controller",
     *   @OA\Property(
     *      property="idUser", 
     *      description="Id of the User",
     *      type="integer",
     *      @OA\Schema(type="int", example="1")
     *   ),
     *   @OA\Property(
     *      property="userLastname",
     *      description="Lastname of User",
     *      type="string",
     *      @OA\Schema(type="string", example="Saucisse")
     *   ),
     *   @OA\Property(
     *      property="userFirstname",
     *      description="Firstname of User",
     *      type="string",
     *      @OA\Schema(type="string", example="John")
     *   ),
     *   @OA\Property(
     *      property="userEmail",
     *      description="Email of User",
     *      type="string",
     *      @OA\Schema(type="string", example="client@lumina.fr")
     *   ),
     *   @OA\Property(
     *      property="userDob",
     *      description="Date of birth of User",
     *      type="date",
     *      @OA\Schema(type="date", example="1990-01-01")
     *   ),
     *   @OA\Property(
     *      property="userPassword",
     *      description="Password of the User",
     *      type="string",
     *      @OA\Schema(type="string", example="dflbog")
     *   ),
     *   @OA\Property(
     *      property="userPhone",
     *      description="Phone of User",
     *      type="string",
     *      @OA\Schema(type="string", example="0102030405")
     *   ),
     *   @OA\Property(
     *      property="userAdr",
     *      description="Adress of User",
     *      type="string",
     *      @OA\Schema(type="string", example="1 rue de truc")
     *   ),
     * )
     */
class UserController extends Controller
{

    
    
    /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get the authenticated User.
     *
     * @return Response
     */
    public function profile()
    {
        return response()->json(['user' => Auth::user()], 200);
    }

/**
  * @OA\Get(
  *   path="/api/v1/users",
  *   summary="Return the list of users",
  *   tags={"User"},
  *    @OA\Response(
  *      response=200,
  *      description="List of users",
  *      @OA\JsonContent(
  *        @OA\Property(
  *          property="data",
  *          description="List of users"
  *          )
  *        )
  *      )
  *    )
  * )
*/
    public function allUsers()
    {
         return response()->json(['users' =>  User::all()], 200);
    }

/**
  * @OA\Get(
  *   path="/user/{idUser}",
  *   summary="Get one user information",
  *   tags={"User"},
  *   @OA\Parameter(ref="#/components/parameters/get_users_request_parameter_limit"),
  *    @OA\Response(
  *      response=200,
  *      description="User retrieved",
  *      @OA\JsonContent(
  *        @OA\Property(
  *          property="data",
  *          description="Get one user"
  *          )
  *        )
  *      )
  *    )
  * )
  */
    public function singleUser($idUser)
    {
        try {
            $user = User::findOrFail($idUser);

            return response()->json(['user' => $user], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'user not found!'], 404);
        }

    }
/**
  * @OA\Delete(
  *   path="/user/{idUser}",
  *   summary="Delete user",
  *   tags={"User"},
  *   @OA\Parameter(ref="#/components/parameters/get_users_request_parameter_limit"),
  *    @OA\Response(
  *      response=200,
  *      description="Delete user",
  *      @OA\JsonContent(
  *        @OA\Property(
  *          property="data",
  *          description="Delete user"
  *          )
  *        )
  *      )
  *    )
  * )
  */
    public function deleteUser($idUser) 
    {
        try {
            User::findOrFail($idUser)->delete();
            return response()->json(['message' => 'user deleted'], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'user not found!'], 404);
        }
    }

    public function updateUser($idUser, Request $request)
    {
        try {
            $user = User::findOrFail($idUser);
            $user->update($request->all());

            return response()->json(['user' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'user not found!'], 404);
        }
    }
}