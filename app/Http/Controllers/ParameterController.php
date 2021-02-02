<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Parameter;

class ParameterController extends Controller
{
    /**
     * Store a new parameter.
     *
     * @param  Request  $request
     * @return Response
     */
    public function createParameter(Request $request) {
        //validate incoming request 

       try {
          
           $parameter = new Parameter;

           $parameter->save();

           //return successful response
           return response()->json(['parameter' => $parameter, 'message' => 'CREATED'], 201);

       } catch (\Exception $e) {
           //return error message
           return response()->json(['message' => 'Parameter Creation Failed!'], 409);
       }
   }



    /**
     * Get all parameters.
     *
     * @return Response
     */
    public function allParameters()
    {
        return response()->json(['parameter' => Parameter::all()], 200);
    }

    /**
     * Get one property.
     *
     * @return Response
     */
    public function singleParameter($idParameter)
    {
        try {
            $parameter = Parameter::findOrFail($idParameter);

            return response()->json(['parameter' => $parameter], 200);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Parameter not found!'], 404);
        }
    }

    /**
     * Remove Parameter.
     */
    public function deleteParameter($idParameter) 
    {
        try {
            Parameter::findOrFail($idParameter)->delete();
            return response()->json(['message' => 'Parameter deleted'], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Parameter not found!'], 404);
        }
    }

    public function updateParameter($idParameter, Request $request)
    {
        try {
            $parameter = Parameter::findOrFail($idParameter);
            $parameter->update($request->all());

            return response()->json(['parameter' => $parameter], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'user not found!'], 404);
        }
    }
}
