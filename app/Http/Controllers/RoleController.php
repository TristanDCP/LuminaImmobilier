<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Role;

class RoleController extends Controller
{
/**
  * @OA\Post(
  *   path="/role",
  *   summary="Create a role",
  *   tags={"Role"},
  *    @OA\Response(
  *      response=200,
  *      description="Role created",
  *      @OA\JsonContent(
  *        @OA\Property(
  *          property="data",
  *          description="Create a role"
  *          )
  *        )
  *      )
  *    )
  * )
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
            return response()->json(['message' => 'Role Registration Failed!'], 409);
        }
    }

/**
  * @OA\Get(
  *   path="/roles",
  *   summary="Retrieves list of all roles",
  *   tags={"Role"},
  *    @OA\Response(
  *      response=200,
  *      description="Role created",
  *      @OA\JsonContent(
  *        @OA\Property(
  *          property="data",
  *          description="Create a role"
  *          )
  *        )
  *      )
  *    )
  * )
  */
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
