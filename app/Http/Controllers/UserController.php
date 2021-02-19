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
     */

    /**
     * @OA\Parameter(
     *   parameter="get_user_id",
     *   name="idUser",
     *   description="Replace the user id",
     *   in="path",
     *   @OA\Schema(
     *     type="integer", default=1
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