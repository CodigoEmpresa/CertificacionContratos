<?php
session_start();
/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
	Route::get('/', function () { return view('welcome'); });

	/************************************/
	Route::any('/', 'MainController@index');
	Route::any('/logout', 'MainController@logout');

	

	Route::get('/personas', '\Idrd\Usuarios\Controllers\PersonaController@index');
	Route::get('/personas/service/obtener/{id}', '\Idrd\Usuarios\Controllers\PersonaController@obtener');
	Route::get('/personas/service/buscar/{key}', '\Idrd\Usuarios\Controllers\PersonaController@buscar');
	Route::get('/personas/service/ciudad/{id_pais}', '\Idrd\Usuarios\Controllers\LocalizacionController@buscarCiudades');
	Route::post('/personas/service/procesar/', '\Idrd\Usuarios\Controllers\PersonaController@procesar');	
	/************************************/




//rutas con filtro de autenticación
Route::group(['middleware' => ['web']], function () {


	/********************ADMINISTRACION***************************/

	/********************Asignación de personas***************************/
	Route::get('gestor_tabla','GestorDatosController@index');

	Route::post('revAdicion', 'GestorDatosController@RevisionAdicion');
	Route::post('revProrroga', 'GestorDatosController@RevisionProrroga');
	Route::post('revSuspencion', 'GestorDatosController@RevisionSuspencion');
	Route::post('revCesion', 'GestorDatosController@RevisionCesion');
	Route::post('revObligacion', 'GestorDatosController@RevisionObligacion');

	Route::post('AddContrato', 'GestorDatosController@AgregarContrato');

	Route::get('getContrato','GestorDatosController@GetContrato');	
	Route::get('getContratoOne/{id_contrato}','GestorDatosController@GetContratoOne');	
	
});
