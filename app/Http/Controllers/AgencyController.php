<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Agency;

/**
 * @OA\Schema(
 *      schema="allAgencies",
 *      title="Agency Model",
 *      description="Agencies",
 *      @OA\Property(
 *          property="idAgency", description="Agency ID",
 *          @OA\Schema(type="number", example=1)
 *      ),
 *      @OA\Property(
 *          property="agencyName", description="Agency Name",
 *          @OA\Schema(type="string", example="Lumina Le Havre")
 *      ),
 *      @OA\Property(
 *          property="agencyAdr", description="Agency Address",
 *          @OA\Schema(type="string", example="10 Rue de la République")
 *      ),
 *      @OA\Property(
 *          property="agencyPhone", description="Agency Phone Number",
 *          @OA\Schema(type="number", example=0235125895)
 *      ),
 *      @OA\Property(
 *          property="agencyContact", description="Agency Contact",
 *          @OA\Schema(type="string", example="agence-lehavre@lumina.fr")
 *      ),
 * )
 */
class AgencyController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/v1/agency",
     *      summary="Create one Agency",
     *      tags={"Agencies"},     
     *      security={{"bearer_token":{}}},
     *      @OA\Parameter(
     *          parameter="agencyName",
     *          name="agencyName",
     *          description="agencyName",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          parameter="agencyAdr",
     *          name="agencyAdr",
     *          description="agencyAdr",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          parameter="agencyPhone",
     *          name="agencyPhone",
     *          description="agencyPhone",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *      @OA\Parameter(
     *          parameter="agencyContact",
     *          name="agencyContact",
     *          description="agencyContact",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Agency created",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="idAgency",
     *                          type="integer",
     *                          description="Appointment ID"
     *                      ),
     *                      @OA\Property(
     *                          property="agencyName",
     *                          type="string",
     *                          description="Agency Name"
     *                      ),
     *                      @OA\Property(
     *                          property="agencyAdr",
     *                          type="string",
     *                          description="Address Agency",
     *                      ),
     *                      @OA\Property(
     *                          property="agencyPhone",
     *                          type="integer",
     *                          description="Agency Phone",
     *                      ),
     *                      @OA\Property(
     *                          property="agencyContact",
     *                          type="string",
     *                          description="Agency Contact",
     *                      ),
     *                      example={
     *                          "agency": {
     *                              {
     *                                  "idAgency": 1,
     *                                  "agencyName": "Lumina - Le Havre",
     *                                  "agencyAdr": "1 Boulevard de Strasbourg",
     *                                  "agencyPhone": 0101010101,
     *                                  "agencyContact": "contactlehavre@lumina.com",
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
     *          description="Agency Registration Failed!",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Agency Registration Failed!"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     * )
     */
    public function createAgency(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'agencyName' => 'required|string',
            'agencyAdr' => 'required|string',
            'agencyPhone' => 'required|string',
            'agencyContact' => 'required|email',
        ]);

        try {

            $agency = new Agency;
            $agency->agencyName = $request->input('agencyName');
            $agency->agencyAdr = $request->input('agencyAdr');
            $agency->agencyPhone = $request->input('agencyPhone');
            $agency->agencyContact = $request->input('agencyContact');

            $agency->save();

            //return successful response
            return response()->json(['agency' => $agency, 'message' => 'Agency created'], 201);
        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Agency Registration Failed!'], 409);
        }
    }


    /**
     * @OA\Get(
     *      path="/api/v1/agencies",
     *      summary="Return the list of agencies",
     *      tags={"Agencies"},
     *      @OA\Response(
     *          response=200,
     *          description="Agencies found",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="idAgency",
     *                          type="integer",
     *                          description="Appointment ID"
     *                      ),
     *                      @OA\Property(
     *                          property="agencyName",
     *                          type="string",
     *                          description="Agency Name"
     *                      ),
     *                      @OA\Property(
     *                          property="agencyAdr",
     *                          type="string",
     *                          description="Address Agency",
     *                      ),
     *                      @OA\Property(
     *                          property="agencyPhone",
     *                          type="integer",
     *                          description="Agency Phone",
     *                      ),
     *                      @OA\Property(
     *                          property="agencyContact",
     *                          type="string",
     *                          description="Agency Contact",
     *                      ),
     *                      example={
     *                          "agency": {
     *                              {
     *                                  "idAgency": 1,
     *                                  "agencyName": "Lumina - Le Havre",
     *                                  "agencyAdr": "1 Boulevard de Strasbourg",
     *                                  "agencyPhone": 0101010101,
     *                                  "agencyContact": "contactlehavre@lumina.com",
     *                              },
     *                              {
     *                                  "idAgency": 1,
     *                                  "agencyName": "Lumina - Paris",
     *                                  "agencyAdr": "1 Boulevard de Strasbourg",
     *                                  "agencyPhone": 0101010101,
     *                                  "agencyContact": "contactparis@lumina.com",
     *                              }
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
     *          description="Agencies not found!",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Agencies not found!"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     * )
     */
    public function allAgency()
    {
        try {
            return response()->json(['agency' =>  Agency::all()], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Agencies not found!'], 404);
        }
        
    }

    /**
     * @OA\Get(
     *      path="/api/v1/agency/{idAgency}",
     *      summary="Return one agency info",
     *      tags={"Agencies"},
     *      @OA\Parameter(
     *          parameter="idAgency",
     *          name="idAgency",
     *          description="idAgency",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Agency Found",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="idAgency",
     *                          type="integer",
     *                          description="Appointment ID"
     *                      ),
     *                      @OA\Property(
     *                          property="agencyName",
     *                          type="string",
     *                          description="Agency Name"
     *                      ),
     *                      @OA\Property(
     *                          property="agencyAdr",
     *                          type="string",
     *                          description="Address Agency",
     *                      ),
     *                      @OA\Property(
     *                          property="agencyPhone",
     *                          type="integer",
     *                          description="Agency Phone",
     *                      ),
     *                      @OA\Property(
     *                          property="agencyContact",
     *                          type="string",
     *                          description="Agency Contact",
     *                      ),
     *                      example={
     *                          "agency": {
     *                              {
     *                                  "idAgency": 1,
     *                                  "agencyName": "Lumina - Le Havre",
     *                                  "agencyAdr": "1 Boulevard de Strasbourg",
     *                                  "agencyPhone": 0101010101,
     *                                  "agencyContact": "contactlehavre@lumina.com",
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
     *          description="Agency not found!",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Agency not found!"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     * )
     */
    public function singleAgency($idAgency)
    {
        try {
            $agency = Agency::findOrFail($idAgency);

            return response()->json(['agency' => $agency], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Agency not found!'], 404);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/agency/{idAgency}",
     *      summary="Delete one agency",
     *      tags={"Agencies"},     
     *      security={{"bearer_token":{}}}, 
     *      @OA\Parameter(
     *          parameter="idAgency",
     *          name="idAgency",
     *          description="idAgency",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="Agency deleted",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Agency deleted"
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
     *          description="Agency not deleted!",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Agency not deleted!"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     * )
     */
    public function deleteAgency($idAgency)
    {
        try {
            Agency::findOrFail($idAgency)->delete();
            return response()->json(['message' => 'Agency deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Agency not deleted!'], 404);
        }
    }

    /**
     * @OA\Put(
     *      path="/api/v1/agency/{idAgency}",
     *      summary="Update one Agency",
     *      tags={"Agencies"},     
     *      security={{"bearer_token":{}}},
     *      @OA\Parameter(
     *          parameter="idAgency",
     *          name="idAgency",
     *          description="idAgency",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ), 
     *      @OA\Parameter(
     *          parameter="agencyName",
     *          name="agencyName",
     *          description="agencyName",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          parameter="agencyAdr",
     *          name="agencyAdr",
     *          description="agencyAdr",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          parameter="agencyPhone",
     *          name="agencyPhone",
     *          description="agencyPhone",
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *      @OA\Parameter(
     *          parameter="agencyContact",
     *          name="agencyContact",
     *          description="agencyContact",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Agency updated",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="idAgency",
     *                          type="integer",
     *                          description="Appointment ID"
     *                      ),
     *                      @OA\Property(
     *                          property="agencyName",
     *                          type="string",
     *                          description="Agency Name"
     *                      ),
     *                      @OA\Property(
     *                          property="agencyAdr",
     *                          type="string",
     *                          description="Address Agency",
     *                      ),
     *                      @OA\Property(
     *                          property="agencyPhone",
     *                          type="integer",
     *                          description="Agency Phone",
     *                      ),
     *                      @OA\Property(
     *                          property="agencyContact",
     *                          type="string",
     *                          description="Agency Contact",
     *                      ),
     *                      example={
     *                          "agency": {
     *                              {
     *                                  "idAgency": 1,
     *                                  "agencyName": "Lumina - Le Havre",
     *                                  "agencyAdr": "1 Boulevard de Strasbourg",
     *                                  "agencyPhone": 0101010101,
     *                                  "agencyContact": "contactlehavre@lumina.com",
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
     *          description="Agency not updated!",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Agency not updated!"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     * )
     */
    public function updateAgency($idAgency, Request $request)
    {
        try {
            $agency = Agency::findOrFail($idAgency);
            $agency->update($request->all());

            return response()->json(['agency' => $agency], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Agency not updated!'], 404);
        }
    }
}
