<?php

namespace App\Http\Controllers;

use App\Property;

class PropertyController extends Controller
{
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

            return response()->json(['property' => $property], 200);
        } catch (\Exception $e) {

            return response()->json(['message' => 'user not found!'], 404);
        }
    }
}
