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

use Illuminate\Support\Facades\Route;

Route::any('api-documentation', function(){
    return 'this is api documentation ';
});

Route::controller('/user', 'UserController');
Route::controller('/auth', 'AuthController');

Route::controller('/attach-file', '\\App\\Http\\Controllers\\AttachFileController');

Route::controller('/test', '\\App\\Http\\Controllers\\TestController');

Route::get('/app','\\App\\Http\\Controllers\\AppController@main');
Route::get('/app/{any}','\\App\\Http\\Controllers\\AppController@main')->where('any', '.*');

Route::controller('/', '\\App\\Http\\Controllers\\HomeController');
