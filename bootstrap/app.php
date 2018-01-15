<?php

/* LOAD COMPOSER */
require_once __DIR__ . '/../vendor/autoload.php';

/* LOAD .env */
(new Dotenv\Dotenv(__DIR__ . '/../'))->load();

/* START LUMEN */
$app = new Laravel\Lumen\Application(
        realpath(__DIR__ . '/../')
);

/* ADD ELOQUENT */
$app->withFacades(true, [
    Tymon\JWTAuth\Facades\JWTAuth::class => 'JWTAuth',
    Tymon\JWTAuth\Facades\JWTFactory::class => 'JWTFactory'
]);
$app->withEloquent();

// JWT AUTHENTIFICATION
//https://github.com/tymondesigns/jwt-auth/issues/1102#issuecomment-296712123
$app->register(Tymon\JWTAuth\Providers\LumenServiceProvider::class);

$app->singleton(
        Illuminate\Contracts\Debug\ExceptionHandler::class, Laravel\Lumen\Exceptions\Handler::class
);
$app->singleton(
        Illuminate\Contracts\Console\Kernel::class, Laravel\Lumen\Console\Kernel::class
);



$app->routeMiddleware([
    'jwt-auth' => App\Http\Middleware\Authenticate::class,
]);

/* ROUTING */
$app->router->post('/login', 'App\\Http\\Controllers\\AuthController@login');
$app->router->post('/logout', 'App\\Http\\Controllers\\AuthController@logout');

$app->router->group(['middleware' => 'jwt-auth'], function() use ($app) {

    /* DEFINIDO EN TOKEN JWT: */
    $app->router->post('/me', function (Illuminate\Http\Request $request) {
        return $request->user();
    });

    $app->router->post('{class}/{method}', function (Illuminate\Http\Request $request, $class, $method) use ($app) {
        $controller = $app->make("App\\Http\\Controllers\\" . ucwords($class) . "Controller");
        return $controller->$method($request);
    });
});

$app->router->post('{all}', function (Illuminate\Http\Request $request, $ruta) {
    return "no encontrado $ruta";
});
$app->router->get('{all}', function (Illuminate\Http\Request $request, $ruta) {
    return "no están permitidas peticiones get";
});



return $app;
