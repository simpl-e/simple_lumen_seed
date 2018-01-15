<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use App\Usuario;

class UserController extends Controller {

    public function usuario(Request $request) {
        //acceder datos del token (sesión)
        $usuario = $request->user();
        
        //devolver del ORM Model de Eloquent
        return Usuario::where("Id", $usuario->Id)->first();
    }

}
