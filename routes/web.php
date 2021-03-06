<?php

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

/*--- RUTAS DE LOGIN ---*/
Route::get('/', function(){
  return view('login');
})->name('login.view');
Route::get('login', function(){
  return view('login');
});
Route::post('auth', 'LoginController@auth')->name('login.auth');
Route::match(['get', 'post'], '/logout', 'LoginController@logout')->name('login.logout');

Route::get('registro', 'EmpresasController@create')->name('empresas.create');
Route::post('registro', 'EmpresasController@store')->name('empresas.store');

/* --- Solo usuarios autenticados --- */
Route::group([ 'middleware' => ['auth'] ], function () {

  /* --- Dashboard --- */
  Route::get('dashboard', 'LoginController@dashboard')->name('dashboard');

  /* --- Empresas --- */
  Route::get('/perfil', 'EmpresasController@perfil')->name('empresas.perfil');
  Route::get('/perfil/edit', 'EmpresasController@edit' )->name('empresas.edit');
  Route::patch('/perfil', 'EmpresasController@update')->name('empresas.update');

  /* --- Empleados --- */
  Route::get('empleados/{empleado}/cambio', 'EmpleadosController@cambio')->name('empleados.cambio');
  Route::post('empleados/{empleado}/cambio', 'EmpleadosController@cambioStore')->name('empleados.cambioStore');
  Route::post('empleados/{empleado}/export', 'EmpleadosController@export')->name('empleados.export');
  Route::get('empleados/calendar', 'EmpleadosController@calendar')->name('empleados.calendar');
  Route::post('empleados/export', 'EmpleadosController@exportAll')->name('empleados.exportAll');
  Route::resource('empleados', 'EmpleadosController');

  /* --- Documentos --- */
  Route::resource('documentos', 'EmpleadosDocumentosController')->except([
    'show',
  ]);
  Route::get('documentos/create/{empleado}', 'EmpleadosDocumentosController@create')->name('documentos.create');
  Route::post('documentos/store/{empleado}', 'EmpleadosDocumentosController@store')->name('documentos.store');
  Route::get('documentos/download/{documento}', 'EmpleadosDocumentosController@download')->name('documentos.download');

  /* --- Eventos --- */
  Route::get('eventos/export', 'EmpleadosEventosController@events')->name('eventos.events');
  Route::post('eventos/export', 'EmpleadosEventosController@exportEventsTotal')->name('eventos.export');
  Route::post('eventos/events', 'EmpleadosEventosController@getEvents')->name('eventos.getEvents');
  Route::get('eventos/', 'EmpleadosEventosController@index')->name('eventos.index');
  Route::post('eventos/{empleado}', 'EmpleadosEventosController@store')->name('eventos.store');
  Route::delete('eventos/{evento}', 'EmpleadosEventosController@destroy')->name('eventos.destroy');
});