<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    $services = [
        [
            'pivot' => [
                'account_id' => 0,
                'service_id' => 15
            ]
        ],
        [
            'pivot' => [
                'account_id' => 0,
                'service_id' => 47
            ]
        ]
    ];

    $new_services = array_pluck($services, 'pivot.service_id');
    print_r($new_services);
});

//Person
Route::get('/person/{id}/{lang?}', 'PersonController@getPerson');
Route::post('/person', 'PersonController@store');
Route::post('/person/account', 'PersonController@ownAccount');

//Account
Route::get('/account/{id}', 'AccountController@getAccount');
Route::post('/account', 'AccountController@store');

//Text
Route::get('/text/{id}/{lang}', 'MainController@index');
Route::post('/text', 'TextController@store');

//Language
Route::post('/language', 'LanguageController@store');