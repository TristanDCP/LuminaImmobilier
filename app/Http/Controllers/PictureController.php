<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Picture;
use App\hasPicture;

/**
 * @OA\Schema(
 *      schema="Pictures",
 *      title="Picture Model",
 *      description="Pictures",
 *      @OA\Property(
 *          property="idPicture", description="ID of the picture",
 *          type="integer",
 *          @OA\Schema(type="number", example=1)
 *      ),
 *      @OA\Property(
 *          property="pictureURL", description="URL of the picture",
 *          type="string",
 *          @OA\Schema(type="string", example="img.png")
 *      ),
 * )
 */
class PictureController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/v1/property/{idProperty}/{idPiece}",
     *      summary="Create a picture",
     *      tags={"Pictures"},
     *      security={{"bearer_token":{}}},
     *      @OA\Parameter(
     *          parameter="pictureURL",
     *          name="pictureURL",
     *          description="pictureURL",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
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
     *          parameter="idPiece",
     *          name="idPiece",
     *          description="idPiece",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Picture created",
     *          content = {
     *              @OA\MediaType(         
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="idPicture",
     *                          type="integer",
     *                          description="Picture ID"
     *                      ),
     *                      @OA\Property(
     *                          property="pictureURL",
     *                          type="string",
     *                          description="Picture URL",
     *                      ),
     *                      example = {
     *                          "picture": {
     *                              "idPicture": 1,
     *                              "pictureURL": "example.png",
     *                          },
     *                      }
     *                  )
     *              )
     *          }
     *      ),
     *      @OA\Response(
     *          response=401,
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
     *          response=404,
     *          description="Picture Registration Failed !",
     *          content = {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example = {
     *                          "message": "Picture Registration Failed !"
     *                      }
     *                  )
     *              )
     *          },
     *      )
     *    
     * )
    */
    public function createPicture(Request $request) {
         //validate incoming request 
         $this->validate($request, [
            'pictureURL' => 'required|string', 
        ]);

        try {
           
            $picture = new Picture;
            $picture->pictureURL = $request->input('pictureURL');

            $picture->save();

            $hasPicture = new hasPicture;
            $hasPicture->idPicture = $picture->idPicture;
            $hasPicture->idProperty = $request->idProperty;
            $hasPicture->save();

            //return successful response
            return response()->json(['picture' => $picture, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Picture Creation Failed!'], 409);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/property/{idProperty}/{idPiece}/{idPicture}",
     *      summary="Return one picture info",
     *      tags={"Pictures"},
     *      @OA\Parameter(
     *          parameter="idPicture",
     *          name="idPicture",
     *          description="idPicture",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ),
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
     *          parameter="idPiece",
     *          name="idPiece",
     *          description="idPiece",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Picture Found",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="idPicture",
     *                          type="integer",
     *                          description="Picture ID"
     *                      ),
     *                      @OA\Property(
     *                          property="pictureURL",
     *                          type="string",
     *                          description="Picture URL"
     *                      ),
     *                      @OA\Property(
     *                          property="idProperty",
     *                          type="integer",
     *                          description="Property ID"
     *                      ),
     *                      @OA\Property(
     *                          property="idPiece",
     *                          type="integer",
     *                          description="Piece ID"
     *                      ),
     *                      example={
     *                          "agency": {
     *                              {
     *                                  "idPicture": 8,
     *                                  "pictureURL": "test.png",
     *                                  "idProperty": 4,
     *                                  "idPiece": 1,
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
     *          description="Picture not found!",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Picture not found!"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     * )
     */
    public function singlePicture($idPicture)
    {
        try {
            $picture = Picture::findOrFail($idPicture);

            return response()->json(['picture' => $picture], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Picture not found!'], 404);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/property/{idProperty}/{idPiece}/{idPicture}",
     *      summary="Delete one picture",
     *      tags={"Pictures"},     
     *      security={{"bearer_token":{}}}, 
     *      @OA\Parameter(
     *          parameter="idPicture",
     *          name="idPicture",
     *          description="idPicture",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ),
     *      @OA\Parameter(
     *          parameter="idPiece",
     *          name="idPiece",
     *          description="idPiece",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          )
     *      ),
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
     *          response=200,
     *          description="Picture deleted",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Picture deleted"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     *      @OA\Response(
     *          response=401,
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
     *          response=404,
     *          description="Picture not deleted!",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Picture not deleted!"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     * )
     */
    public function deletePicture($idPicture)
    {
        try {
            Picture::findOrFail($idPicture)->delete();
            return response()->json(['message' => 'Picture deleted'], 200);
        } catch(\Exception $e) {
            return response()->json(['message' => 'Picture not found!'], 404);
        }
    }
}
