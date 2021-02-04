<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\User;

// We can define the User Scheme here or in our App\User model
/**
 * @OA\Schema(
 *   schema="UserSchema",
 *   title="User Model",
 *   description="User controller",
 *   @OA\Property(
 *     property="id", description="ID of the user",
 *     @OA\Schema(type="number", example=1)
 *  ),
 *   @OA\Property(
 *     property="name", description="Name of the user",
 *     @OA\Schema(type="string", example="User Name")
 *  )
 * )
 */
// We can define the request parameter inside the Requests or here
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
  *   path="/userlist",
  *   summary="Return the list of users",
  *   tags={"User List"},
  *   @OA\Parameter(ref="#/components/parameters/get_users_request_parameter_limit"),
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
      
    /**
     * Get all User.
     *
     * @return Response
     */
    public function allUsers()
    {
         return response()->json(['users' =>  User::all()], 200);
    }

/**
  * @OA\Get(
  *   path="/user/profile",
  *   summary="Return one user profile",
  *   tags={"User List"},
  *   @OA\Parameter(ref="#/components/parameters/get_users_request_parameter_limit"),
   *    @OA\Response(
  *      response=200,
  *      description="One user profile",
  *      @OA\JsonContent(
  *        @OA\Property(
  *          property="data",
  *          description="One user profile"
  *          )
  *        )
  *      )
  *    )
  * )
  */
    /**
     * Get one user.
     *
     * @return Response
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
  *   path="/user/delete",
  *   summary="Delete user",
  *   tags={"User List"},
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
     
    /**
     * Remove User.
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