<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group([
    'prefix' => 'api'
], function ($router) {
    $router->post('login', 'AuthController@login');
    $router->post('logout', 'AuthController@logout');
    $router->post('refresh', 'AuthController@refresh');
    $router->post('user-profile', 'AuthController@me');
});

$router->group([
    'prefix' => 'api/products',
    'middleware' => 'auth'
], function ($router) {
    $router->get('/', 'ProductController@index');       
    $router->post('/', 'ProductController@store');       
    $router->get('/{id}', 'ProductController@show');     
    $router->put('/{id}', 'ProductController@update');   
    $router->delete('/{id}', 'ProductController@destroy');
});