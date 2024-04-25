<?php
    $router->group(['prefix' => 'api/v1'], function () use ($router) {
        $router->group(['middleware' => 'auth'], function() use ($router) {
            $router->get('/products/search', 'ProductController@search');
            $router->get('/products', 'ProductController@index');
            $router->get('/products/{id}', 'ProductController@show');
            $router->post('/products', 'ProductController@store');
            $router->put('/products/{id}', 'ProductController@update');
            $router->delete('/products/{id}', 'ProductController@delete');
        });
    });