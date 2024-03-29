<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\TicketController;

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

$router->group(['prefix' => 'api/v1/'], function ($router) {
    $router->group([], function ($router) {

        $router->get('skills', ['uses' => 'SkillController@index']);
        $router->get('information', ['uses' => 'InformationController@index']);
        $router->get('clients', ['uses' => 'ClientController@index']);
        $router->get('experiences', ['uses' => 'ExperienceController@index']);
        $router->get('services', ['uses' => 'ServiceController@index']);
        $router->post('tickets', ['uses' => 'TicketController@store']);
        $router->post('login', ['uses' => 'AuthController@login']);
        $router->post('register', ['uses' => 'AuthController@register']);
    });


    $router->group(['middleware' => ['auth']], function ($router) {
        // skills routes
        $router->post('auth', ['uses' => 'AuthController@checkAuth']);
        $router->post('skills', ['uses' => 'SkillController@store']);
        $router->put('skills/{skill}', ['uses' => 'SkillController@update']);
        $router->delete('skills/{skill}', ['uses' => 'SkillController@delete']);

        // ticket routes
        $router->get('tickets', ['uses' => 'TicketController@index']);
        $router->delete('tickets/{id}', ['uses' => 'TicketController@delete']);

        // information routes
        $router->post('information', ['uses' => 'InformationController@store']);
        $router->put('information', ['uses' => 'InformationController@update']);
        $router->delete('information/{information}', ['uses' => 'InformationController@delete']);

        // clients routes
        $router->post('clients', ['uses' => 'ClientController@store']);
        $router->put('clients/{client}', ['uses' => 'ClientController@update']);
        $router->delete('clients/{client}', ['uses' => 'ClientController@delete']);

        // experiences routes
        $router->post('experiences', ['uses' => 'ExperienceController@store']);
        $router->put('experiences/{experience}', ['uses' => 'ExperienceController@update']);
        $router->delete('experiences/{experience}', ['uses' => 'ExperienceController@delete']);

        // services routes
        $router->post('services', ['uses' => 'ServiceController@store']);
        $router->put('services/{service}', ['uses' => 'ServiceController@update']);
        $router->delete('services/{service}', ['uses' => 'ServiceController@delete']);
    });

});
