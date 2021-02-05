<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Picture;
use App\hasPicture;

/**
 * @OA\Schema(
 *   schema="PictureSchema",
 *   title="Picture Model",
 *   description="Picture controller",
 *   @OA\Property(
 *     property="idPicture", description="ID of the document",
 *     type="integer",
 *     @OA\Schema(type="number", example=1)
 *   ),
 *   @OA\Property(
 *      property="pictureURL", description="URL of the document",
 *      type="string",
 *      @OA\Schema(type="string", example="img.png")
 *   ),
 * )
 */
class PictureController extends Controller
{
    /**
     * @OA\Post(
     *   path="/api/v1/property/{idProperty}/{idPiece}",
     *   summary="Create a picture",
     *   tags={"Pictures"},
     *      @OA\RequestBody(
     *         @OA\JsonContent(
     *          @OA\Property(
     *             property="pictureURL",
     *             description="URL of the picture",
     *             example="img.png",
     *             type="string"
     *          ),
     *          @OA\Property(
     *             property="idProperty",
     *             description="Id of the Property",
     *             example="1",
     *             type="integer"
     *          )
     *        )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Picture created"      
     *      ),
     *      @OA\Response(
     *          response=409,
     *          description="Picture Creation Failed !"
     *      )
     *    )
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
     *   path="/api/v1/property/{idProperty}",
     *   summary="Return the list of pictures",
     *   tags={"Pictures"},
     *   @OA\Parameter(
     *      parameter="idProperty",
     *      name="idProperty",
     *      description="Id of a specific property",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *          type="integer",
     *          format="int64",
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *      description="List of pictures"      
     *   )
     * )
    */
    public function allPictures()
    {
        return response()->json(['picture' =>  Picture::all()], 200);
    }

    /**
     * @OA\Get(
     *   path="/api/v1/property/{idProperty}/{idPiece}/{idPicture}",
     *   summary="Return a Picture",
     *   tags={"Pictures"},
     *   @OA\Parameter(
     *      parameter="idPicture",
     *      name="idPicture",
     *      description="Id of a specific Picture",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *          type="integer",
     *          format="int64",
     *      )
     *   ),
     *   @OA\Parameter(
     *      parameter="idPiece",
     *      name="idPiece",
     *      description="Id of a specific Piece",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *          type="integer",
     *          format="int64",
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *      description="Successfull operation"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="Document not found !"
     *   ),
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
     *   path="/api/v1/property/{idProperty}/{idPiece}/{idPicture}",
     *   summary="Delete a Picture",
     *   tags={"Pictures"},
     *   @OA\Parameter(
     *      parameter="idProperty",
     *      name="idProperty",
     *      description="Id of a specific Property",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *          type="integer",
     *          format="int64",
     *      )
     *   ),
     *   @OA\Parameter(
     *      parameter="idPiece",
     *      name="idPiece",
     *      description="Id of a specific Piece",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *          type="integer",
     *          format="int64",
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *      description="Document deleted"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="Document not found !"
     *   ),
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
