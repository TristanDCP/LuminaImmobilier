<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Property;
use App\hasParameter;
use App\Parameter;

class PropertyController extends Controller
{
    /**
     * Store a new property.
     *
     * @param  Request  $request
     * @return Response
     */
    public function createProperty(Request $request) {
        //validate incoming request 
        $this->validate($request, [
            'propertyStatus' => 'required|integer',
            'idUser' => 'required|integer',
            'propertyParameters' => 'required|string',
        ]);

        try {
           
            $property = new Property;
            $property->propertyStatus = $request->input('propertyStatus');
            $property->idUser = $request->input('idUser');

            /*
                Recup les param (json)
                Parse les data : key / value
                -> OK : insert into propertyparameters
                -> OK : ajout des id dans la table hasParameter
            */
            
            $param = new Parameter;
            $param->keyParameter = $request->input('propertyParameters');
            $param->valueParameter = "foo";
            
            $property->save();
            $propertyId = $property->idProperty;
            $param->save();
            $paramId = $param->idParameter;

            $hasParam = new hasParameter;
            $hasParam->idProperty = $propertyId;
            $hasParam->idParameter = $paramId;
            $hasParam->save();

            //return successful response
            return response()->json(['property' => $property, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Property Registration Failed!'], 409);
        }
    }


    /**
     * Get all Properties.
     *
     * @return Response
     */
    public function allProperties()
    {
        return response()->json(['property' =>  Property::all()], 200);
    }

    /**
     * Get one property.
     *
     * @return Response
     */
    public function singleProperty($idProperty)
    {
        try {
            $property = Property::findOrFail($idProperty);
            $parameters = $this->getParameters($idProperty);
            return response()->json(['property' => $property, 'parameters' => $parameters], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Property not found!'], 404);
        }
    }

    /**
     * Remove Property.
     */
    public function deleteProperty($idProperty) 
    {
        try {
            Property::findOrFail($idProperty)->delete();
            return response()->json(['message' => 'Property deleted'], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Property not found!'], 404);
        }
    }

    public function updateProperty($idProperty, Request $request)
    {
        try {
            $property = Property::findOrFail($idProperty);
            $property->update($request->all());

            return response()->json(['property' => $property], 200);
        } catch (\Exception $e) {
            //return response()->json(['message' => 'user not found!'], 404);
            return $e->getMessage();
        }
    }

    public function getParameters($idProperty)
    {
        $query = DB::table('property')
            ->join('hasParameter', 'property.idProperty', '=', 'hasParameter.idProperty')
            ->join('propertyparameters', 'hasParameter.idParameter', '=', 'propertyparameters.idParameter')
            ->select('propertyparameters.*')
            ->where('property.idProperty', $idProperty)
            ->get();
        
        return $query;

    }

    public function setParameters($idProperty)
    {

    }

}
