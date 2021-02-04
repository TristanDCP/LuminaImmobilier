<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Piece;

class PieceController extends Controller
{
    /**
     * Store a new property.
     *
     * @param  Request  $request
     * @return Response
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
     * Get one piece.
     *
     * @return Response
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
     * Remove a piece.
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
     * Update a piece.
     */
    public function updatePiece($idPiece, Request $request)
    {
        try {
            $piece = Piece::findOrFail($idPiece);
            $request->input('pieceName')     !== null ? $piece->pieceName = $request->input('pieceName')               : null;
            $request->input('pieceSurface')  !== null ? $piece->pieceSurface = intval($request->input('pieceSurface')) : null;
            $request->input('pieceExposure') !== null ? $piece->pieceExposure = $request->input('pieceExposure')       : null;

            return response()->json(['piece' => $piece, 'message' => 'UPDATED'], 200);
        } catch(\Exception $e) {
            return response()->json(['message' => 'Piece not found!'], 404);
        }
    }
}
