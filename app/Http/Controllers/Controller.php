<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
/**
 * @OA\Info(
 *   title="Lumina API",
 *  version="1.0.0",
 *  @OA\Contact(
 *    email="tristandacostapinto@gmail.com",
 *    name="L'équipe 2"
 *  )
 * )
 */
    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'user' => auth()->user(),
        ], 200);
    }
}
