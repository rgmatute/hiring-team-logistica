<?php

require __DIR__.'/../routes/account.php';
require __DIR__.'/../routes/catalog.php';
require __DIR__.'/../routes/product.php';
require __DIR__.'/../routes/history.php';

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

//Fix to Method OPTIONS
$router->options('/{any:.*}', function () {
    return response(['status' => 'success'])
        ->header('Access-Control-Allow-Methods','OPTIONS, GET, POST, PUT, DELETE')
        ->header('Access-Control-Allow-Headers', 'Authorization, Content-Type, Origin');
});

$router->get('/', function () use ($router) {
    // return $router->app->version();
    return response()->json([
        'success' => true,
        'framework' => $router->app->version()
    ]);
});


$router->get('/key', function () use ($router) {
    $length = 32; // Longitud de la clave (en bytes)
    $randomBytes = random_bytes($length);
    $appKey = base64_encode($randomBytes);
    return response()
                ->json([
                    'success' => true,
                    "key" => $appKey
                ]);
});

