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
    echo 'HR';
});

Route::get('/index', function() {
    echo 'INDEX';
});

//Person
Route::get('/person/{id}/{lang?}', 'PersonController@getPerson');
Route::post('/person', 'PersonController@store');
Route::post('/person/account', 'PersonController@ownAccount');
Route::post('/person/facepic/{id}', 'PersonController@changeFacePic');
Route::post('/person/{id}', 'PersonController@update');

//Evaluation
Route::get('/evaluation/{id}/{lang?}', 'EvaluationController@get');
Route::post('/evaluation/{id}', 'EvaluationController@store');

//Group
Route::get('/group/{id}/{lang?}', 'GroupController@get');
Route::post('/group', 'GroupController@store');
Route::post('/group/{id}', 'GroupController@update');

//Account
Route::get('/account/{id}', 'AccountController@getAccount');
Route::post('/account', 'AccountController@store');

//Text
Route::get('/text/{id}/{lang}', 'MainController@index');
Route::post('/text', 'TextController@store');

//Language
Route::post('/language', 'LanguageController@store');
Route::get('/language/{lang?}', 'LanguageController@index');

//Attachment
Route::post('/attachment', 'AttachmentController@upload');
Route::get('/attachment/{id}', 'AttachmentController@getAttachment');
Route::delete('/attachment/{id}', 'AttachmentController@removeAttachment');

//Items
Route::get('/countries/{lang?}', 'MainController@getCountries');
Route::get('/account/types', 'MainController@getAccountTypes');
Route::get('/certification/types/{lang?}', 'MainController@getCertificationTypes');
Route::get('/evaluation/methods/{lang?}', 'MainController@getEvaluationMethods');
Route::get('/skill/types/{lang?}', 'MainController@getSkillTypes');

//Tests
Route::post('/test/evaluation', 'TestController@testEvaluation');
Route::post('/test/person', 'TestPerson@runStore');
Route::post('/test/cert', 'TestPerson@testCert');
Route::post('/test/group', 'TestController@testGroup');