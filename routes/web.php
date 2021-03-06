<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('principal');
});

// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

  Route::prefix('cliente')->group(function() {
    Route::get('allCliente','ClienteController@allCliente');
    Route::post('register','ClienteController@register');
    Route::put('actualizar', 'ClienteController@update');
    Route::put('desactivar', 'ClienteController@desactivar');
    Route::put('activar', 'ClienteController@activar');
  });


  Route::prefix('venta')->group(function() {
    Route::get('allVenta','VentaController@allVenta');
    Route::post('register','VentaController@register');
    Route::put('desactivar', 'VentaController@desactivar');
  });


  Route::prefix('informes')->group(function() {
    Route::get('grafica','InformeController@grafica');
  });



