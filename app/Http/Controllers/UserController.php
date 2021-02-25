<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

/**
 * @OA\Schema(
 *      schema="Users",
 *      title="Users Model",
 *      description="Users",
 *      @OA\Property(
 *          property="idUser", description="User Id",
 *          @OA\Schema(type="number", example=1)
 *      ),
 *      @OA\Property(
 *          property="userLastname", description="User Lastname",
 *          @OA\Schema(type="string", example="Doe")
 *      ),
 *      @OA\Property(
 *          property="userFirstname", description="User Firstname",
 *          @OA\Schema(type="string", example="John")
 *      ),
 *      @OA\Property(
 *          property="userEmail", description="User Email",
 *          @OA\Schema(type="string", example="johndoe@gmail.com")
 *      ),
 *      @OA\Property(
 *          property="userDob", description="User birth date",
 *          @OA\Schema(type="number", example="2020-01-01")
 *      ),
 *      @OA\Property(
 *          property="userPhone", description="User contact",
 *          @OA\Schema(type="number", example=0203040506)
 *      ),
 *      @OA\Property(
 *          property="userAdr", description="User address",
 *          @OA\Schema(type="string", example="1 Boulevard de Strasbourg")
 *      ),
 *      @OA\Property(
 *          property="idRole", description="User role",
 *          @OA\Schema(type="string", example=1)
 *      ),
 *      @OA\Property(
 *          property="idAgency", description="Agency related to the Users",
 *          @OA\Schema(type="string", example=1)
 *      ),
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
     *      path="/api/v1/users",
     *      summary="Return the list of users",
     *      tags={"Users"},
     *      security={{"bearer_token":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Users found",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="idUser",
     *                          type="integer",
     *                          description="User ID"
     *                      ),
     *                      @OA\Property(
     *                          property="userLastname",
     *                          type="string",
     *                          description="User Lastname"
     *                      ),
     *                      @OA\Property(
     *                          property="userFirstname",
     *                          type="string",
     *                          description="User Firstname",
     *                      ),
     *                      @OA\Property(
     *                          property="userEmail",
     *                          type="string",
     *                          description="User Email",
     *                      ),
     *                      @OA\Property(
     *                          property="userDob",
     *                          type="date",
     *                          description="User birth date",
     *                      ),
     *                      @OA\Property(
     *                          property="userPhone",
     *                          type="integer",
     *                          description="User Phone",
     *                      ),
     *                      @OA\Property(
     *                          property="userAdr",
     *                          type="string",
     *                          description="User Address",
     *                      ),
     *                      @OA\Property(
     *                          property="idRole",
     *                          type="integer",
     *                          description="Role given to the user",
     *                      ),
     *                      @OA\Property(
     *                          property="idAgency",
     *                          type="integer",
     *                          description="Agency related to the user",
     *                      ),
     *                      example={
     *                          "users": {
     *                              {
     *                                  "idUser": 1,
     *                                  "userLastname": "John",
     *                                  "userFirstname": "Doe",
     *                                  "userEmail": "johndoe@gmail.com",
     *                                  "userDob": "1990-01-01",
     *                                  "userPhone": 0235874125,
     *                                  "userAdr": "1 Boulevard de strasbourg",
     *                                  "idRole": 1,
     *                                  "idAgency": 2
     *                              },
     *                              {
     *                                  "idUser": 2,
     *                                  "userLastname": "John",
     *                                  "userFirstname": "Dope",
     *                                  "userEmail": "johndope@gmail.com",
     *                                  "userDob": "1990-01-01",
     *                                  "userPhone": 0236258412,
     *                                  "userAdr": "1 Boulevard de strasbourg",
     *                                  "idRole": 2,
     *                                  "idAgency": 1
     *                              },
     *                          }
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     *      @OA\Response(
     *          response="401",
     *          description="Unauthorized",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example="Unauthorized"
     *                  )
     *              )
     *          },
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Users not found!",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Users not found!"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     * )
     */
    public function allUsers()
    {
        try {
            return response()->json(['users' =>  User::all()], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Users not found!'], 404);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/user/{idUser}",
     *      summary="Return the list of one user",
     *      tags={"Users"},
     *      security={{"bearer_token":{}}},
     *      @OA\Parameter(
     *          parameter="idUser",
     *          name="idUser",
     *          description="idUser",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User found",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="idUser",
     *                          type="integer",
     *                          description="User ID"
     *                      ),
     *                      @OA\Property(
     *                          property="userLastname",
     *                          type="string",
     *                          description="User Lastname"
     *                      ),
     *                      @OA\Property(
     *                          property="userFirstname",
     *                          type="string",
     *                          description="User Firstname",
     *                      ),
     *                      @OA\Property(
     *                          property="userEmail",
     *                          type="string",
     *                          description="User Email",
     *                      ),
     *                      @OA\Property(
     *                          property="userDob",
     *                          type="date",
     *                          description="User birth date",
     *                      ),
     *                      @OA\Property(
     *                          property="userPhone",
     *                          type="integer",
     *                          description="User Phone",
     *                      ),
     *                      @OA\Property(
     *                          property="userAdr",
     *                          type="string",
     *                          description="User Address",
     *                      ),
     *                      @OA\Property(
     *                          property="idRole",
     *                          type="integer",
     *                          description="Role given to the user",
     *                      ),
     *                      @OA\Property(
     *                          property="idAgency",
     *                          type="integer",
     *                          description="Agency related to the user",
     *                      ),
     *                      example={
     *                          "users": {
     *                              {
     *                                  "idUser": 1,
     *                                  "userLastname": "John",
     *                                  "userFirstname": "Doe",
     *                                  "userEmail": "johndoe@gmail.com",
     *                                  "userDob": "1990-01-01",
     *                                  "userPhone": 0235874125,
     *                                  "userAdr": "1 Boulevard de strasbourg",
     *                                  "idRole": 1,
     *                                  "idAgency": 2
     *                              },
     *                          }
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     *      @OA\Response(
     *          response="401",
     *          description="Unauthorized",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example="Unauthorized"
     *                  )
     *              )
     *          },
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="User not found!",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "User not found!"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     *  )
     */
    public function singleUser($idUser)
    {
        try {
            $user = User::findOrFail($idUser);

            return response()->json(['user' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'User not found!'], 404);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/user/{idUser}",
     *      summary="Delete one user",
     *      tags={"Users"},
     *      security={{"bearer_token":{}}},
     *      @OA\Parameter(
     *          parameter="idUser",
     *          name="idUser",
     *          description="idUser",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="User deleted",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "User deleted"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     *      @OA\Response(
     *          response="401",
     *          description="Unauthorized",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example="Unauthorized"
     *                  )
     *              )
     *          },
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="User not deleted!",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "User not deleted!"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     *  )
     */
    public function deleteUser($idUser)
    {
        try {
            User::findOrFail($idUser)->delete();
            return response()->json(['message' => 'User deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'User not deleted!'], 404);
        }
    }

    /**
     * @OA\Put(
     *      path="/api/v1/user/{idUser}",
     *      summary="Update info on one user",
     *      tags={"Users"},
     *      security={{"bearer_token":{}}},
     *      @OA\Parameter(
     *          parameter="idUser",
     *          name="idUser",
     *          description="idUser",
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ),
     *      @OA\Parameter(
     *          parameter="userLastname",
     *          name="userLastname",
     *          description="userLastname",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *        parameter="userFirstname",
     *        name="userFirstname",
     *        description="userFirstname",
     *        in="query",
     *        @OA\Schema(
     *            type="string",
     *        )
     *      ),
     *      @OA\Parameter(
     *        parameter="userPassword",
     *        name="userPassword",
     *        description="userPassword",
     *        in="query",
     *        @OA\Schema(
     *            type="string",
     *        )
     *      ),
     *      @OA\Parameter(
     *        parameter="userEmail",
     *        name="userEmail",
     *        description="userEmail",
     *        in="query",
     *        @OA\Schema(
     *            type="string",
     *        )
     *      ),
     *      @OA\Parameter(
     *        parameter="userDob",
     *        name="userDob",
     *        description="userDob",
     *        in="query",
     *        @OA\Schema(
     *            type="date",
     *        )
     *      ),
     *      @OA\Parameter(
     *        parameter="userPhone",
     *        name="userPhone",
     *        description="userPhone",
     *        in="query",
     *        @OA\Schema(
     *            type="integer",
     *            format="int64",
     *        )
     *      ),
     *      @OA\Parameter(
     *        parameter="userAdr",
     *        name="userAdr",
     *        description="userAdr",
     *        in="query",
     *        @OA\Schema(
     *            type="string",
     *        )
     *      ),
     *      @OA\Parameter(
     *        parameter="userAdr",
     *        name="userAdr",
     *        description="userAdr",
     *        in="query",
     *        @OA\Schema(
     *            type="string",
     *        )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User found",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="idUser",
     *                          type="integer",
     *                          description="User ID"
     *                      ),
     *                      @OA\Property(
     *                          property="userLastname",
     *                          type="string",
     *                          description="User Lastname"
     *                      ),
     *                      @OA\Property(
     *                          property="userFirstname",
     *                          type="string",
     *                          description="User Firstname",
     *                      ),
     *                      @OA\Property(
     *                          property="userEmail",
     *                          type="string",
     *                          description="User Email",
     *                      ),
     *                      @OA\Property(
     *                          property="userDob",
     *                          type="date",
     *                          description="User birth date",
     *                      ),
     *                      @OA\Property(
     *                          property="userPhone",
     *                          type="integer",
     *                          description="User Phone",
     *                      ),
     *                      @OA\Property(
     *                          property="userAdr",
     *                          type="string",
     *                          description="User Address",
     *                      ),
     *                      @OA\Property(
     *                          property="idRole",
     *                          type="integer",
     *                          description="Role given to the user",
     *                      ),
     *                      @OA\Property(
     *                          property="idAgency",
     *                          type="integer",
     *                          description="Agency related to the user",
     *                      ),
     *                      example={
     *                          "users": {
     *                              {
     *                                  "idUser": 1,
     *                                  "userLastname": "John",
     *                                  "userFirstname": "Doe",
     *                                  "userEmail": "johndoe@gmail.com",
     *                                  "userDob": "1990-01-01",
     *                                  "userPhone": 0235874125,
     *                                  "userAdr": "1 Boulevard de strasbourg",
     *                                  "idRole": 1,
     *                                  "idAgency": 2
     *                              },
     *                          }
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     *      @OA\Response(
     *          response="401",
     *          description="Unauthorized",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example="Unauthorized"
     *                  )
     *              )
     *          },
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="User not updated!",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "User not updated!"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     * )
     */
    public function updateUser($idUser, Request $request)
    {
        try {
            $user = User::findOrFail($idUser);
            $user->update($request->all());

            return response()->json(['user' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'User not updated!'], 404);
        }
    }
}
