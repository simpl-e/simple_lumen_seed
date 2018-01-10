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
$app->withFacades();
$app->withEloquent();


$app->singleton(
        Illuminate\Contracts\Debug\ExceptionHandler::class, Laravel\Lumen\Exceptions\Handler::class
);
$app->singleton(
        Illuminate\Contracts\Console\Kernel::class, Laravel\Lumen\Console\Kernel::class
);

/* ROUTING */
$app->router->get('{class}/{method}', function ($class, $method) use ($app) {
    $controller = $app->make("App\\Http\\Controllers\\{$class}Controller");
    return $controller->$method();
});

return $app;
