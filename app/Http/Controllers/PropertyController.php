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
            'propertyParameters' => 'required|json',
        ]);

        try {
           
            $property = new Property;
            $property->propertyStatus = $request->input('propertyStatus');
            $property->idUser = $request->input('idUser');
            $property->save();
            $propertyId = $property->idProperty;

            $json = json_decode($request->input('propertyParameters'), true);
            
            foreach( $json as $k => $v ){
                $parameter = new Parameter;
               
                $keys = array_keys($v);
                $values = array_values($v);

                $parameter->keyParameter = $keys[0];
                $parameter->valueParameter = $values[0];

                $parameter->save();
                $parameterId = $parameter->idParameter;

                $hasParam = new hasParameter;
                $hasParam->idProperty = $propertyId;
                $hasParam->idParameter = $parameterId;
                $hasParam->save();
            };

            //return successful response
            return response()->json(['property' => $property, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            // debug return
            return $e->getMessage();
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
        /*
            OK -> Récup le bien en fonction de l'id donné
            OK -> Récup les params du bien
            OK -> Parser les params de la requête
            OK -> Parser les params actuelles du bien
            OK -> Comparer les deux listes de param
            OK -> Stocker les deux listes dans des tableaux
            OK -> Comparer les tableaux
            OK -> Ajouter les nouveaux params
            Mettre à jour les params existant
            Save
        */
        try {
            $property = Property::findOrFail($idProperty);
            $oldParameters = $this->getParameters($idProperty);
            
            $requestParameters = json_decode($request->input('propertyParameters'), true);

            $array1 = []; // les anciens param
            $array2 = []; // les nouveaux param
            
            foreach( $oldParameters as $k => $v ){
                $oldParameterKey = $v->keyParameter;
                $oldParameterValue = $v->valueParameter;
                $array1[$oldParameterKey] = $oldParameterValue;  
            };

            foreach( $requestParameters as $k => $v ){
                $requestParametersKeys = implode('|', array_keys($v));
                $requestParametersValues = implode('|', array_values($v));
                $array2[$requestParametersKeys] = $requestParametersValues;
            };

            $result = array_diff($array2, $array1);
            if($result != null) {
                foreach($result as $resultKey => $resultValue) {
                    /*
                    $parameter = new Parameter;
                    $parameter->keyParameter = $resultKey;
                    $parameter->valueParameter = $resultValue;

                    $parameter->save();
                    $parameterId = $parameter->idParameter;

                    $hasParam = new hasParameter;
                    $hasParam->idProperty = $property->idProperty;
                    $hasParam->idParameter = $parameterId;
                    $hasParam->save();
                    */
                }
            }

            $property->update($request->all());

            return response()->json(['property' => $property, 'message' => 'CREATED', 'array_diff' => $result], 200);
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
}
