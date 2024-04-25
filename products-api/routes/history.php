<?php
    $router->group(['prefix' => 'api/v1'], function () use ($router) {
        $router->group(['middleware' => 'auth'], function() use ($router) {
            $router->get('/history/search', 'HistoryController@search');
        });
    });