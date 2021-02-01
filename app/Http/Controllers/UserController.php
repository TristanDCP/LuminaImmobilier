<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\User;

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
     * Get all User.
     *
     * @return Response
     */
    public function allUsers()
    {
         return response()->json(['users' =>  User::all()], 200);
    }

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
            //return response()->json(['message' => 'user not found!'], 404);
            return $e->getMessage();
        }
    }
}