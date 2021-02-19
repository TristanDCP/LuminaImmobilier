<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Agency;

/**
 * @OA\Schema(
 *   schema="allAgencies",
 *   title="Agency Model",
 *   description="Agencies",
 *   @OA\Property(
 *     property="{idAgency}", description="ID of the agency",
 *     @OA\Schema(type="number", example=1)
 *      ),
 *   @OA\Property(
 *     property="agencyName", description="Name of the agency",
 *     @OA\Schema(type="string", example="Lumina Le Havre")
 *      ),
 *   @OA\Property(
 *      property="agencyAdr", description="Address of the agency",
 *      @OA\Schema(type="string", example="10 Rue de la République")
 *   ),
 *   @OA\Property(
 *      property="agencyPhone", description="Phone Number of the agency",
 *      @OA\Schema(type="number", example=0235125895)
 *   ),
 *   @OA\Property(
 *      property="agencyContact", description="Contact of the agency",
 *      @OA\Schema(type="string", example="agence-lehavre@lumina.fr")
 *   ),
 * )
 */
class AgencyController extends Controller
{
    /**
     * Store a new agency.
     *
     * @param  Request  $request
     * @return Response
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
            return response()->json(['agency' => $agency, 'message' => 'CREATED'], 201);
        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Agency Registration Failed!'], 409);
        }
    }


    /**
     * @OA\Get(
     *   path="/api/v1/agencies",
     *   summary="Return the list of agencies",
     *   tags={"Agencies"},
     *    @OA\Response(
     *      response=200,
     *      description="List of agencies",
     *      @OA\JsonContent(
     *        @OA\Property(
     *          property="idAgency", 
     *          description="ID of the agency",
     *          @OA\Schema(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/allAgencies"),
     *          )
     *        ),
     *      )
     *    )
     *  )
     */
    public function allAgency()
    {
        return response()->json(['agency' =>  Agency::all()], 200);
    }

    /**
     * @OA\Get(
     *   path="/api/v1/agency/{idAgency}",
     *   summary="Return one agency info",
     *   tags={"Agencies"},
     *   @OA\Parameter(
     *      parameter="idAgency",
     *      name="idAgency",
     *      description="idAgency",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *          type="integer",
     *          format="int64",
     *      )
     *    ),
     *    @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/allAgencies")
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Invalid ID supplied"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Agency not found"
     *     ),
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
     *   path="/api/v1/agency/{idAgency}",
     *   summary="Delete one agency",
     *   tags={"Agencies"},     
     *   security={{"bearer_token":{}}}, 
     *   @OA\Parameter(
     *      parameter="idAgency",
     *      name="idAgency",
     *      description="idAgency",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *          type="integer",
     *          format="int64",
     *      )
     *    ),
     *    @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/allAgencies")
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Invalid ID supplied"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Agency not found"
     *     ),
     * )
     */
    public function deleteAgency($idAgency)
    {
        try {
            Agency::findOrFail($idAgency)->delete();
            return response()->json(['message' => 'Agency deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Agency not found!'], 404);
        }
    }

    /**
     * @OA\Put(
     *   path="/api/v1/agency/{idAgency}",
     *   summary="Update one Agency",
     *   tags={"Agencies"},     
     *   security={{"bearer_token":{}}},
     *   @OA\Parameter(
     *      parameter="idAgency",
     *      name="idAgency",
     *      description="idAgency",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *          type="integer",
     *          format="int64",
     *      )
     *   ), 
     *   @OA\Parameter(
     *      parameter="agencyName",
     *      name="agencyName",
     *      description="agencyName",
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      )
     *   ),
     *   @OA\Parameter(
     *      parameter="agencyAdr",
     *      name="agencyAdr",
     *      description="agencyAdr",
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      )
     *   ),
     *   @OA\Parameter(
     *      parameter="agencyPhone",
     *      name="agencyPhone",
     *      description="agencyPhone",
     *      in="query",
     *      @OA\Schema(
     *          type="integer",
     *      )
     *   ),
     *   @OA\Parameter(
     *      parameter="agencyContact",
     *      name="agencyContact",
     *      description="agencyContact",
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      )
     *   ),
     *    @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/allAgencies")
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Invalid ID supplied"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Agency not found"
     *     ),
     * )
     */
    public function updateAgency($idAgency, Request $request)
    {
        try {
            $agency = Agency::findOrFail($idAgency);
            $agency->update($request->all());

            return response()->json(['agency' => $agency], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'user not found!'], 404);
        }
    }
}
