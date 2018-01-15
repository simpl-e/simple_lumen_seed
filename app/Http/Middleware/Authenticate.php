<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;

class Authenticate {

    public function handle($request, Closure $next) {
        //SIMULAR EN HEADER LA COOKIE JWT
        $jwt = $request->cookie('Authorization');
        if (!$jwt) {
            return response('falta token', 401);
        }

        $request->headers->set('Authorization', $jwt);

        JWTAuth::parser()->setRequest($request);

        try {
            $user = JWTAuth::parseToken($jwt)->authenticate();
        } catch (\Exception $e) {
            return response('error en el token', 401);
        }
        
        if (!$user) {
            return response('token incorrecto', 401);
        }

        return $next($request);
    }

}
