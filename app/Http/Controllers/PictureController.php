<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Picture;

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
}
