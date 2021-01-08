<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Role;

class RoleController extends Controller
{
    /**
     * Store a new Role.
     *
     * @param  Request  $request
     * @return Response
     */
    public function createRole(Request $request) {
         //validate incoming request 
         $this->validate($request, [
            'roleName' => 'required|string', 
        ]);

        try {
           
            $role = new Role;
            $role->roleName = $request->input('roleName');

            $role->save();

            //return successful response
            return response()->json(['role' => $role, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Property Registration Failed!'], 409);
        }
    }

    /**
     * Get all Roles.
     *
     * @return Response
     */
    public function allRoles()
    {
        return response()->json(['role' =>  Role::all()], 200);
    }
}
