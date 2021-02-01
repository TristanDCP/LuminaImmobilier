<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Agency;

class AgencyController extends Controller
{
    /**
     * Store a new property.
     *
     * @param  Request  $request
     * @return Response
     */
    public function createAgency(Request $request) {
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
     * Get all Properties.
     *
     * @return Response
     */
    public function allAgency()
    {
        return response()->json(['agency' =>  Agency::all()], 200);
    }

    /**
     * Get one property.
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
            //return response()->json(['message' => 'user not found!'], 404);
            return $e->getMessage();
        }
    }
}
