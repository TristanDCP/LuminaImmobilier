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
 *     property="idAgency", description="ID of the agency",
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

/**
 * @OA\Parameter(
 *   parameter="token",
 *   name="Token",
 *   description="Token",
 *   in="query",
 *   @OA\Schema(
 *     type="string",
 *   )
 * ),
 */
class AgencyController extends Controller
{

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
     *          property="data",
     *          description="List of agencies",
     *          @OA\Schema(
     *            type="array",
     *            @OA\Items(ref="#/components/schemas/allAgencies"),
     *          ),
     *          @OA\Example(
     *              id=1,
     *              agencyName="Lumina Le Havre",
     *          )        
     *        )
     *      )
     *    )
     *  )
     */
    public function allAgency()
    {
        return response()->json(['agency' =>  Agency::all()], 200);
    }

    /**
     * Get one agency.
     *
     * @return Response
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
     * Remove Agency.
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
