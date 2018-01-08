<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

//LOAD COMPOSER
require_once 'vendor/autoload.php';

//LOAD .env
(new Dotenv\Dotenv(__DIR__))->load();

//START LARAVEL
$app = new Laravel\Lumen\Application();

//ADD ELOQUENT
$app->withFacades();
$app->withEloquent();

//ROUTING
$app->router->get('{class}/{method}', function ($class, $method) use ($app) {
    $controller = $app->make("App\\Http\\Controllers\\$class");
    return $controller->$method();
});

//RUN
$app->run();
