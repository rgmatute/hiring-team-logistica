<?php
    $router->group(['prefix' => 'api/v1'], function () use ($router) {
        $router->group(['middleware' => 'auth'], function() use ($router) {
            $router->get('/catalogs/search', 'CatalogController@search');
            $router->get('/catalogs', 'CatalogController@index');
            $router->get('/catalogs/{id}', 'CatalogController@show');
            $router->post('/catalogs', 'CatalogController@store');
            $router->put('/catalogs/{id}', 'CatalogController@update');
            $router->delete('/catalogs/{id}', 'CatalogController@delete');
        });
    });