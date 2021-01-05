<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

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
            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }

    }

    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
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

        if(! $token = Auth::attempt(['userEmail'=>$email, 'password' =>$password])) {
            return response()->json(['message' => 'Failed to login'], 401);
        }

        return $this->respondWithToken($token);
    }
    
}