<?php

/* ROUTING */
$router->post('/login', 'AuthController@login');
$router->post('/logout', 'AuthController@logout');

$router->group(['middleware' => 'jwt-auth'], function() use ($router) {

    $router->post('{class}/{method}', function (Illuminate\Http\Request $request, $class, $method) {
        $controller = app()->make("App\\Http\\Controllers\\" . ucwords($class) . "Controller");
        return $controller->$method($request);
    });
});

$router->post('{all}', function (Illuminate\Http\Request $request, $ruta) {
    return "no se ha encontrado $ruta";
});
$router->get('{all}', function (Illuminate\Http\Request $request, $ruta) {
    return "no están permitidas peticiones get";
});
