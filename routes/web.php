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

});