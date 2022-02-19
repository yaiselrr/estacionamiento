<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('tipos-vehiculos', TypeCarController::class);
Route::resource('clientes', ClientController::class);
Route::resource('vehiculos', CarController::class);

Route::post('registrar-entrada', 'RegisterController@registerInput');

Route::put('registrar-salida/{enrollment}', 'RegisterController@registerOutput');

Route::get('listado-clientes', 'RegisterController@listOfClients');

Route::get('listado-matriculas', 'RegisterController@listEnrollmentsMax');
