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

$router->group(['prefix' => 'api', 'middleware' => 'request-validator'], function($router) {
    $router->get('/', ['uses' => 'WelcomeController@index']);

    $router->get('/movies', ['uses' => 'MovieController@index']);
    $router->get('/movies/{id}', ['uses' => 'MovieController@show']);

    $router->get('/movies/{id}/comments', ['uses' => 'MovieCommentController@index']);
    $router->post('/movies/{id}/comments', ['uses' => 'MovieCommentController@store']);
    $router->get('/movies/{id}/comments/{commentId}', ['uses' => 'MovieCommentController@show']);

    $router->get('/movies/{id}/characters', ['uses' => 'MovieCharacterController@index']);
    $router->get('/movies/{id}/characters/{characterId}', ['uses' => 'MovieCharacterController@show']);
});

$router->get('/', function () use ($router) {
    return redirect('api');
});
