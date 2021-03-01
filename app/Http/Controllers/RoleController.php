<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Role;

/**
 * @OA\Schema(
 *      schema="Roles",
 *      title="Roles Model",
 *      description="Roles",
 *      @OA\Property(
 *          property="idRole", description="Role ID",
 *          type="integer",
 *          @OA\Schema(type="number", example=1)
 *      ),
 *      @OA\Property(
 *          property="roleName", description="Role Name",
 *          type="string",
 *          @OA\Schema(type="string", example="Patron")
 *      ),
 * )
 */
class RoleController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/v1/role",
     *      summary="Create one Role",
     *      tags={"Roles"},     
     *      security={{"bearer_token":{}}},
     *      @OA\Parameter(
     *          parameter="roleName",
     *          name="roleName",
     *          description="roleName",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Role Created",
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
     *                          "role": {
     *                              "roleName": "Name Role",
     *                              "updatedAt": "2021-02-23T11:31:14.000000Z",
     *                              "createdAt": "2021-02-23T11:31:14.000000Z",
     *                              "idRole": 1 
     *                          },
     *                          "message": "Role Created"
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
     *          description="Role Registration Failed!",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Role Registration Failed!"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     * )
     */
    public function createRole(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'roleName' => 'required|string',
        ]);

        try {

            $role = new Role;
            $role->roleName = $request->input('roleName');

            $role->save();

            //return successful response
            return response()->json(['role' => $role, 'message' => 'Role Created'], 201);
        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Role Registration Failed!'], 409);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/roles",
     *      summary="Return the list of roles",
     *      tags={"Roles"},
     *      security={{"bearer_token":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Roles found",
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
     *                          "role": {
     *                              {
     *                                  "idRole": 1,
     *                                  "roleName": "Role 1",
     *                                  "createdAt": "2021-01-07T15:32:34.000000Z",
     *                                  "updatedAt": "2021-01-07T15:32:34.000000Z",
     *                                  "deletedAt": null
     *                              },
     *                              {
     *                                  "idRole": 2,
     *                                  "roleName": "Role 2",
     *                                  "createdAt": "2021-01-07T15:32:34.000000Z",
     *                                  "updatedAt": "2021-01-07T15:32:34.000000Z",
     *                                  "deletedAt": null
     *                              },
     *                              {
     *                                  "idRole": 3,
     *                                  "roleName": "Role 3",
     *                                  "createdAt": "2021-01-07T15:32:34.000000Z",
     *                                  "updatedAt": "2021-01-07T15:32:34.000000Z",
     *                                  "deletedAt": null
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
     *          description="Roles not found!",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Roles not found!"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     *  )
     */
    public function allRoles()
    {
        try {
            return response()->json(['role' =>  Role::all()], 200);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Roles not found!'], 404);
        }
    }
}
