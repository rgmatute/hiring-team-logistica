<?php

    $router->group(['prefix' => 'api/v1'], function () use ($router) {
        $router->post('/account/authenticate', 'AccountController@login');
        $router->post('/account/logout', 'AccountController@logout');

        $router->group(['middleware' => 'auth'], function() use ($router) {
            $router->get('/account', 'AccountController@accountInfo');
        });        
    });