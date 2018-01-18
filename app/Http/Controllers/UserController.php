<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller {

    public function user(Request $request) {
        //acceder datos del token (sesión)
        $user = $request->user();
        
        //devolver del ORM Model de Eloquent
        return User::where("id", $user->Id)->first();
    }

}
