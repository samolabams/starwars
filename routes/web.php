<?php

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

$router->group(['prefix' => 'api/v1'], function($router) {
    $router->get('/', function () use ($router) {
        return 'Welcome to StarWars API development.';
    });

    $router->get('/movies', ['uses' => 'MovieController@index']);
    $router->get('/movies/{id}', ['uses' => 'MovieController@show']);

    $router->get('/movies/{id}/comments', ['uses' => 'MovieCommentController@index']);
    $router->post('/movies/{id}/comments', ['middleware' => 'api', 'uses' => 'MovieCommentController@store']);
    $router->get('/movies/{id}/comments/{commentId}', ['uses' => 'MovieCommentController@show']);
});

$router->get('/', function () use ($router) {
    return redirect('api/v1');
});
