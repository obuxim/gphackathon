<?php

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/register', ['uses' => 'AuthController@register']);
$router->post('/login', ['uses' => 'AuthController@login']);

$router->get('/{model}/{action}[/{id}]', ['middleware' => 'auth', 'uses' => 'RouterController@serve']);
$router->post('/{model}/{action}[/{id}]', ['middleware' => 'auth', 'uses' => 'RouterController@serve']);
$router->put('/{model}/{action}[/{id}]', ['middleware' => 'auth', 'uses' => 'RouterController@serve']);
$router->patch('/{model}/{action}[/{id}]', ['middleware' => 'auth', 'uses' => 'RouterController@serve']);
$router->delete('/{model}/{action}[/{id}]', ['middleware' => 'auth', 'uses' => 'RouterController@serve']);
