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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();



Route::get('/home', 'HomeController@index')->name('home');

Route::get('/proyectos', 'ProjectController@index');

Route::put('/proyectos/actualizar', 'ProjectController@update');

Route::post('/proyectos/guardar', 'ProjectController@store');

Route::delete('/proyectos/borrar/{id}', 'ProjectController@destroy');

Route::get('/proyectos/buscar', 'ProjectController@show');
