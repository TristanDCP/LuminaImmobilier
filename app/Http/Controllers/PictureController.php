<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Picture;
use App\hasPicture;

class PictureController extends Controller
{
    /**
     * Store a new Picture.
     *
     * @param  Request  $request
     * @return Response
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
     * Get all Pictures.
     *
     * @return Response
     */
    public function allPictures()
    {
        return response()->json(['picture' =>  Picture::all()], 200);
    }

    /**
     * Get one picture.
     *
     * @return Response
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
     * Delete one picture.
     * 
     * @return Reponse
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
