<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Piece;

/**
 * @OA\Schema(
 *      schema="Pieces",
 *      title="Piece Model",
 *      description="Pieces",
 *      @OA\Property(
 *          property="idPiece", description="Piece ID",
 *          type="integer",
 *          @OA\Schema(type="number", example=1)
 *      ),
 *      @OA\Property(
 *          property="pieceName", description="Piece Name",
 *          type="string",
 *          @OA\Schema(type="string", example="Lumina Le Havre")
 *      ),
 *      @OA\Property(
 *          property="pieceSurface", description="Piece Surface",
 *          type="integer",
 *          @OA\Schema(type="number", example="20")
 *      ),
 *      @OA\Property(
 *          property="pieceExposure", description="Piece Exposure",
 *          type="string",
 *          @OA\Schema(type="string", example="SUD")
 *      ),
 *      @OA\Property(
 *          property="idProperty", description="Property ID",
 *          type="integer",
 *          @OA\Schema(type="number", example="1")
 *      ),
 * )
 */
class PieceController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/v1/property/{idProperty}/",
     *      summary="Create a piece",
     *      tags={"Pieces"},
     *      security={{"bearer_token":{}}},
     *      @OA\Parameter(
     *          parameter="pieceyName",
     *          name="pieceName",
     *          description="pieceName",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          parameter="pieceSurface",
     *          name="pieceSurface",
     *          description="pieceSurface",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *      @OA\Parameter(
     *          parameter="pieceExposure",
     *          name="pieceExposure",
     *          description="pieceExposure",
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
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Piece created",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="idPiece",
     *                          type="integer",
     *                          description="Piece ID"
     *                      ),
     *                      @OA\Property(
     *                          property="pieceName",
     *                          type="string",
     *                          description="Piece Name"
     *                      ),
     *                      @OA\Property(
     *                          property="pieceSurface",
     *                          type="string",
     *                          description="Surface of the Piece",
     *                      ),
     *                      @OA\Property(
     *                          property="pieceExposure",
     *                          type="integer",
     *                          description="Exposure of the Piece",
     *                      ),
     *                      @OA\Property(
     *                          property="idProperty",
     *                          type="interger",
     *                          description="Property ID",
     *                      ),
     *                      example={
     *                          "agency": {
     *                              {
     *                                  "idPiece": 1,
     *                                  "pieceName": "Chambre",
     *                                  "pieceSurface": 20,
     *                                  "pieceExposure": "SUD",
     *                                  "idProperty": 4,
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
     *          description="Piece Registration Failed!",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Piece Registration Failed!"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     * )
    */
    public function createPiece(Request $request) {
        //validate incoming request 
        $this->validate($request, [
            'pieceName' => 'required|string',
            'pieceSurface' => 'required|integer',
            'pieceExposure' => 'required|string',
        ]);

        try {
           
            $piece = new Piece;
            $piece->pieceName = $request->input('pieceName');
            $piece->pieceSurface = $request->input('pieceSurface');
            $piece->pieceExposure = $request->input('pieceExposure');
            $piece->idProperty = $request->idProperty;
            $piece->save();

            //return successful response
            return response()->json(['piece' => $piece, 'message' => 'CREATED'], 201);
        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Pieces Registration Failed!'], 409);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/property/{idProperty}/{idPiece}}",
     *      summary="Return one piece info",
     *      tags={"Pieces"},
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
     *          description="Piece Found",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="idPiece",
     *                          type="integer",
     *                          description="Piece ID"
     *                      ),
     *                      @OA\Property(
     *                          property="pieceName",
     *                          type="string",
     *                          description="Piece Name"
     *                      ),
     *                      @OA\Property(
     *                          property="pieceSurface",
     *                          type="string",
     *                          description="Piece Surface",
     *                      ),
     *                      @OA\Property(
     *                          property="pieceExposure",
     *                          type="integer",
     *                          description="Piece Exposure",
     *                      ),
     *                      @OA\Property(
     *                          property="idProperty",
     *                          type="integer",
     *                          description="Property ID",
     *                      ),
     *                      example={
     *                          "agency": {
     *                              {
     *                                  "idPiece": 1,
     *                                  "pieceName": "Chambre",
     *                                  "pieceSurface": 20,
     *                                  "pieceExposure": "SUD",
     *                                  "idProperty": 4,
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
     *          description="Piece not found!",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Piece not found!"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     * )
     */
    public function singlePiece($idPiece)
    {
        try {
            $piece = Piece::findOrFail($idPiece);

            return response()->json(['piece' => $piece], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Piece not found!'], 404);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/property/{idProperty}/{idPiece}",
     *      summary="Delete one piece",
     *      tags={"Pieces"},     
     *      security={{"bearer_token":{}}}, 
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
     *          response="200",
     *          description="Piece deleted",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Piece deleted"
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
     *          description="Piece not deleted!",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Piece not deleted!"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     * )
     */
    public function deletePiece($idPiece) 
    {
        try {
            Piece::findOrFail($idPiece)->delete();
            return response()->json(['message' => 'Piece deleted'], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Piece not found!'], 404);
        }
    }

    /**
     * @OA\Put(
     *      path="/api/v1/property/{idProperty}/{idPiece}",
     *      summary="Update one Piece",
     *      tags={"Pieces"},     
     *      security={{"bearer_token":{}}},
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
     *          parameter="pieceName",
     *          name="pieceName",
     *          description="pieceName",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          parameter="pieceSurface",
     *          name="pieceSurface",
     *          description="pieceSurface",
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *      @OA\Parameter(
     *          parameter="pieceExposure",
     *          name="pieceExposure",
     *          description="pieceExposure",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Parameter(
     *          parameter="idProperty",
     *          name="idProperty",
     *          description="idProperty",
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Piece updated",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="idPiece",
     *                          type="integer",
     *                          description="Piece ID"
     *                      ),
     *                      @OA\Property(
     *                          property="pieceName",
     *                          type="string",
     *                          description="Piece Name"
     *                      ),
     *                      @OA\Property(
     *                          property="pieceSurface",
     *                          type="integer",
     *                          description="Piece Surface",
     *                      ),
     *                      @OA\Property(
     *                          property="pieceExposure",
     *                          type="string",
     *                          description="Piece Exposure",
     *                      ),
     *                      @OA\Property(
     *                          property="idProperty",
     *                          type="string",
     *                          description="Property ID",
     *                      ),
     *                      example={
     *                          "agency": {
     *                              {
     *                                  "idPiece": 1,
     *                                  "pieceName": "Chambre",
     *                                  "pieceSurface": 20,
     *                                  "pieceExposure": "NORD",
     *                                  "idProperty": 4,
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
     *          description="Piece not updated!",
     *          content= {
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *                  @OA\Schema(
     *                      example={
     *                          "message": "Piece not updated!"
     *                      }
     *                  )
     *              )
     *          },
     *      ),
     * )
     */
    public function updatePiece($idPiece, Request $request)
    {
        try {
            $piece = Piece::findOrFail($idPiece);
            $request->input('pieceName')     !== null ? $piece->pieceName = $request->input('pieceName')               : null;
            $request->input('pieceSurface')  !== null ? $piece->pieceSurface = intval($request->input('pieceSurface')) : null;
            $request->input('pieceExposure') !== null ? $piece->pieceExposure = $request->input('pieceExposure')       : null;

            $piece->update($request->all());
            
            return response()->json(['piece' => $piece, 'message' => 'UPDATED'], 200);
        } catch(\Exception $e) {
            return response()->json(['message' => 'Piece not found!'], 404);
        }
    }
}
