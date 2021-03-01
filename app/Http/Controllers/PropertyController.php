<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Property;
use App\Piece;
use App\hasParameter;
use App\Parameter;
use App\Picture;
use App\hasPicture;

/**
 * @OA\Schema(
 *      schema="Property",
 *      title="Property Model",
 *      description="Agencies",
 *      @OA\Property(
 *          property="idProperty", description="Property ID",
 *          type="integer",
 *          @OA\Schema(type="number", example=1)
 *      ),
 *      @OA\Property(
 *          property="propertyStatus", description="Property Status",
 *          type="integer",
 *          @OA\Schema(type="number", example=1)
 *      ),
 *      @OA\Property(
 *          property="idUser", description="User related to the property",
 *          type="integer",
 *          @OA\Schema(type="number", example=1)
 *      ),
 * )
 */

class PropertyController extends Controller
{
    /**
     * Store a new property.
     *
     * @param  Request  $request
     * @return Response
     */
    public function createProperty(Request $request)
    {
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

            foreach ($json as $k => $v) {
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
     * @OA\Get(
     *      path="/api/v1/properties",
     *      summary="Return the list of properties",
     *      tags={"Properties"},
     *      @OA\Response(
     *          response=200,
     *          description="Properties found",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="idProperty",
     *                          type="integer",
     *                          description="Property ID"
     *                      ),
     *                      @OA\Property(
     *                          property="propertyStatus",
     *                          type="integer",
     *                          description="Property Status"
     *                      ),
     *                      @OA\Property(
     *                          property="idUser",
     *                          type="integer",
     *                          description="User related to the property",
     *                      ),
     *                      example={
     *                          "property": {
     *                              {
     *                                  "idProperty": 1,
     *                                  "propertyStatus": 1,
     *                                  "createdAt": "2021-01-01 12:00:00",
     *                                  "updatedAt": "2021-01-01 12:00:00",
     *                                  "deletedAt": "2021-01-01 12:00:00",
     *                                  "idUser": 1
     *                              },
     *                              {
     *                                  "idProperty": 2,
     *                                  "propertyStatus": 2,
     *                                  "createdAt": "2022-02-01 12:00:00",
     *                                  "updatedAt": "2022-02-01 12:00:00",
     *                                  "deletedAt": "2022-02-01 12:00:00",
     *                                  "idUser": 2
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
     *          description="Properties not found!",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Properties not found!"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     * )
     */
    public function allProperties()
    {
        try {
            return response()->json(['property' =>  Property::all()], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Properties not found!'], 404);
        }
    }

    public function singleProperty($idProperty)
    {
        try {
            $property = Property::findOrFail($idProperty);
            $parameters = $this->getParameters($idProperty);
            $pieces = $this->getPieces($idProperty);
            $pictures = $this->getPictures($idProperty);
            return response()->json(['property' => $property, 'parameters' => $parameters, 'pieces' => $pieces, 'pictures' => $pictures], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Property not found!'], 404);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/property/{idProperty}",
     *      summary="Delete one property",
     *      tags={"Properties"},     
     *      security={{"bearer_token":{}}}, 
     *      @OA\Parameter(
     *          parameter="idProperty",
     *          name="idProperty",
     *          description="idProperty",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="Property deleted",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Property deleted"
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
     *          description="Property not deleted!",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Property not deleted!"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     * )
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

    /**
     * @OA\Put(
     *      path="/api/v1/property/{idProperty}",
     *      summary="Update one Property",
     *      tags={"Properties"},     
     *      security={{"bearer_token":{}}},
     *      @OA\Parameter(
     *          parameter="idProperty",
     *          name="idProperty",
     *          description="idProperty",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ), 
     *      @OA\Parameter(
     *          parameter="propertyStatus",
     *          name="propertyStatus",
     *          description="propertyStatus",
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *      @OA\Parameter(
     *          parameter="idUser",
     *          name="idUser",
     *          description="idUser",
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *      @OA\Parameter(
     *          parameter="propertyParameters",
     *          name="propertyParameters",
     *          description="propertyParameters",
     *          in="query",
     *          @OA\Schema(
     *              type="json",
     *          )
     *      ), 
     *      @OA\Response(
     *          response=200,
     *          description="Property updated",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="idProperty",
     *                          type="integer",
     *                          description="Property ID"
     *                      ),
     *                      @OA\Property(
     *                          property="propertyStatus",
     *                          type="integer",
     *                          description="Property Status"
     *                      ),
     *                      @OA\Property(
     *                          property="idUser",
     *                          type="integer",
     *                          description="User related to the property",
     *                      ),
     *                      example={
     *                          "property": {
     *                              {
     *                                  "idProperty": 1,
     *                                  "propertyStatus": 1,
     *                                  "createdAt": "2021-01-01 12:00:00",
     *                                  "updatedAt": "2021-01-01 12:00:00",
     *                                  "deletedAt": null,
     *                                  "idUser": 1
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
     *          description="Property not updated!",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Property not updated!"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     * )
     */
    public function updateProperty($idProperty, Request $request)
    {
        try {
            $property = Property::findOrFail($idProperty);
            $oldParameters = $this->getParameters($idProperty);

            $requestParameters = json_decode($request->input('propertyParameters'), true);

            $oldParametersAsArray = [];
            $requestParametersAsArray = [];

            foreach ($oldParameters as $k => $v) {
                $oldParameterKey = $v->keyParameter;
                $oldParameterValue = $v->valueParameter;
                $oldParametersAsArray[$oldParameterKey] = $oldParameterValue;
            };

            foreach ($requestParameters as $k => $v) {
                $requestParametersKeys = implode('|', array_keys($v));
                $requestParametersValues = implode('|', array_values($v));
                $requestParametersAsArray[$requestParametersKeys] = $requestParametersValues;
            };

            $result = array_diff($requestParametersAsArray, $oldParametersAsArray);
            if ($result != null) {
                foreach ($result as $resultKey => $resultValue) {

                    if (array_key_exists($resultKey, $oldParametersAsArray)) {
                        $test = Parameter::where('keyParameter', '=', $resultKey)->first();
                        $test->valueParameter = $resultValue;
                        $test->save();
                    } else {
                        $parameter = new Parameter;
                        $parameter->keyParameter = $resultKey;
                        $parameter->valueParameter = $resultValue;
                        $parameter->save();
                        $parameterId = $parameter->idParameter;

                        $hasParam = new hasParameter;
                        $hasParam->idProperty = $property->idProperty;
                        $hasParam->idParameter = $parameterId;
                        $hasParam->save();
                    }
                }
            }

            $property->update($request->all());

            return response()->json(['property' => $property, 'message' => 'UPDATED'], 200);
        } catch (\Exception $e) {
            return $e->getMessage();
            // return response()->json(['message' => 'Property not found!'], 404);
        }
    }

    /**
     * Get parameters from a property
     */
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

    /**
     * Get pieces from a property
     */
    public function getPieces($idProperty)
    {
        $query = DB::table('piece')
            ->where('idProperty', $idProperty)
            ->get();

        return $query;
    }

    /**
     * Get pictures from a property
     */
    public function getPictures($idProperty)
    {
        $query = DB::table('property')
            ->join('hasPicture', 'property.idProperty', '=', 'hasPicture.idProperty')
            ->join('picture', 'hasPicture.idPicture', '=', 'picture.idPicture')
            ->select('picture.*')
            ->where('property.idProperty', $idProperty)
            ->get();

        return $query;
    }
}
