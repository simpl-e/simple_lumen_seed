<?php

//https://github.com/tymondesigns/jwt-auth/wiki/Creating-Tokens

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;

class AuthController extends Controller {

    public function login(Request $request) {
        $userRequest = $request->input('email');
        $passRequest = $request->input('password');
        $password = htmlentities(sha1(md5($passRequest)));

        $user = User::where(["email" => $userRequest, "password" => $password])->first();
        if (empty($user)) {
            return;
        }
        
        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::fromUser($user)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        setcookie("Authorization", "Bearer " . $token, time() + 86400, "/"); // 86400 = 1 day
    }

    public function logout() {
        //limpiar cookie
        setcookie("Authorization", "", 0, "/");
    }

}
