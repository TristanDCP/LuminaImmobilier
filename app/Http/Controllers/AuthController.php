<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Schema(
 *      schema="Login",
 *      title="Login Model",
 *      description="Login",
 *      @OA\Property(
 *          property="token", description="User token",
 *          type="string",
 *          @OA\Schema(type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC92MVwvbG9naW4iLCJpYXQiOjE2MTQwNjc3MzIsImV4cCI6MTYxNDA3MTMzMiwibmJmIjoxNjE0MDY3NzMyLCJqdGkiOiJJdDBRWFlMUlZtdWI2ZTJKIiwic3ViIjo2LCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIiwiaWRVc2VyIjo2fQ._YBLX6lmdzM8Qzvgu0J76iyWaiYqtTocJ11xKNuNL7c")
 *      ),
 *      @OA\Property(
 *          property="token_type", description="Token Type",
 *          type="string",
 *          @OA\Schema(type="string", example="bearer")
 *      ),
 *      @OA\Property(
 *          property="expires_in", description="Token expiration date",
 *          type="integer",
 *          @OA\Schema(type="integer", example=3600)
 *      ),
 *      @OA\Property(
 *          property="user", description="Info user",
 *          @OA\Property(
 *              property="idUser", description="User Id",
 *              type="integer",
 *              @OA\Schema(type="number", example=1)
 *          ),
 *          @OA\Property(
 *              property="userLastname", description="User Lastname",
 *              type="string",
 *              @OA\Schema(type="string", example="Doe")
 *          ),
 *          @OA\Property(
 *              property="userFirstname", description="User Firstname",
 *              type="string",
 *              @OA\Schema(type="string", example="John")
 *          ),
 *          @OA\Property(
 *              property="userEmail", description="User Email",
 *              type="string",
 *              @OA\Schema(type="string", example="johndoe@gmail.com")
 *          ),
 *          @OA\Property(
 *              property="userDob", description="User birth date",
 *              type="date",
 *              @OA\Schema(type="number", example="2020-01-01")
 *          ),
 *          @OA\Property(
 *              property="userPhone", description="User contact",
 *              type="integer",
 *              @OA\Schema(type="number", example=0203040506)
 *          ),
 *          @OA\Property(
 *              property="userAdr", description="User address",
 *              type="string",
 *              @OA\Schema(type="string", example="1 Boulevard de Strasbourg")
 *          ),
 *          @OA\Property(
 *              property="idRole", description="User role",
 *              type="integer",
 *              @OA\Schema(type="string", example=1)
 *          ),
 *          @OA\Property(
 *              property="idAgency", description="Agency related to the Users",
 *              type="integer",
 *              @OA\Schema(type="string", example=1)
 *          ),
 *      ),
 * )
 */

class AuthController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'userLastname' => 'required|string',
            'userFirstname' => 'required|string',
            'userEmail' => 'required|email|unique:users',
            'userDob' => 'required|date',
            'userPassword' => 'required|string',
            'userPhone' => 'required|string',
            'userAdr' => 'required|string',
            'idRole' => 'required|string',
        ]);

        try {

            $user = new User;
            $user->userLastname = $request->input('userLastname');
            $user->userFirstname = $request->input('userFirstname');
            $user->userEmail = $request->input('userEmail');
            $user->userDob = $request->input('userDob');
            $user->userPassword = app('hash')->make($request->input('userPassword'));
            $user->userPhone = $request->input('userPhone');
            $user->userAdr = $request->input('userAdr');
            $user->idRole = $request->input('idRole');

            $user->save();

            //return successful response
            return response()->json(['user' => $user, 'message' => 'User Created'], 201);
        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/v1/login",
     *      summary="Login",
     *      tags={"Login / Register"},     
     *      @OA\Parameter(
     *          parameter="userEmail",
     *          name="userEmail",
     *          description="userEmail",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              default="secretaire@lumina.fr",
     *          )
     *      ),
     *      @OA\Parameter(
     *          parameter="userPassword",
     *          name="userPassword",
     *          description="userPassword",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              default="dflbog",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Login successful",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="token",
     *                          type="string",
     *                          description="JWT access token"
     *                      ),
     *                      @OA\Property(
     *                          property="token_type",
     *                          type="string",
     *                          description="Token type"
     *                      ),
     *                      @OA\Property(
     *                          property="expires_in",
     *                          type="integer",
     *                          description="Token expiration in miliseconds",
     *                      ),
     *                      example={
     *                          "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC92MVwvbG9naW4iLCJpYXQiOjE2MTQwNzU4MTgsImV4cCI6MTYxNDA3OTQxOCwibmJmIjoxNjE0MDc1ODE4LCJqdGkiOiJjVmVERTdUVHY2cXE1U05BIiwic3ViIjo2LCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIiwiaWRVc2VyIjo2fQ.tE3Nfx8z_rOAI2zdgY6RWcq60_xfYEmljDsjPGLGWJU",
     *                          "token_type": "bearer",
     *                          "expires_in": 3600,
     *                          "user": {
     *                              "idUser": 6,
     *                              "userLastname": "Lastname",
     *                              "userFirstname": "Firstname",
     *                              "userEmail": "email@email.fr",
     *                              "userDob": "1990-01-01",
     *                              "userPhone": "0102030405",
     *                              "userAdr": "Address",
     *                              "createdAt": "2021-01-07T15:32:35.000000Z",
     *                              "updatedAt": "2021-01-07T15:32:35.000000Z",
     *                              "deletedAt": null,
     *                              "idRole": 4,
     *                              "idAgency": 1
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
     *          description="Failed to Login",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Failed to Login"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     * )
     */
    public function login(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'userEmail' => 'required|string',
            'userPassword' => 'required|string',
        ]);

        $email    = $request->input('userEmail');
        $password = $request->input('userPassword');

        if (!$token = Auth::attempt(['userEmail' => $email, 'password' => $password])) {
            return response()->json(['message' => 'Failed to login'], 401);
        }

        return $this->respondWithToken($token);
    }
}
