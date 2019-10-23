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

Route::get('/gestionar-proyectos', function () {
    return view('admin.proyectos');
});

Route::get('/gestionar-usuarios', function () {
    return view('admin.usuarios');
});

Route::get('/gestionar-catalogos', function () {
    return view('admin.catalogos');
});

Route::get('/gestionar-parametros', function () {
    return view('admin.parametros');
});

Route::get('/ayuda', function () {
    return view('admin.ayuda');
});

Route::get('/perfil-usuario', function () {
    return view('user.profile');
});

Auth::routes();

/*Authentication*//*
Route::post ('/login','Auth\LoginController@login');
Route::post('/password/email','ForgotPasswordController@sendResetLinkEmail');
Route::post('/password/reset','ResetPasswordController@reset');

/*Home page*/
Route::get('/home', 'HomeController@index')->name('home');

/*Manage Projects*/
Route::get('/proyectos', 'ProjectController@index');
Route::put('/proyectos/actualizar', 'ProjectController@update');
Route::post('/proyectos/guardar', 'ProjectController@store');
Route::delete('/proyectos/borrar/{id}', 'ProjectController@destroy');
Route::get('/proyectos/buscar', 'ProjectController@show');
Route::get('/findproject', 'ProjectController@search');

/*Manage Catalogs*/

Route::get('/catalogo', 'CatalogController@getListCatalog');
Route::post('/catalogo/guardar', 'CatalogController@storeItem');
Route::put('/catalogo/actualizar', 'CatalogController@updateItem');
Route::delete('/catalogo/borrar/{id}', 'CatalogController@deleteItem');


/*Manage Project Levels Structure*/
Route::get('/estructura', 'ProjectStructureController@getProjectLevels');
Route::put('/estructura/actualizar', 'ProjectStructureController@update');
Route::post('/estructura/guardar', 'ProjectStructureController@store');
Route::delete('/estructura/borrar/{id}', 'ProjectStructureController@destroy');
Route::get('/estructura/buscar', 'ProjectStructureController@show');

/*Manage Users*/
Route::get('/usuarios', 'UserController@index');
Route::put('/usuarios/actualizar', 'UserController@update');
Route::post('/usuarios/guardar', 'UserController@store');
Route::delete('/usuarios/borrar/{id}', 'UserController@destroy');
Route::get('/usuarios/buscar', 'UserController@show');
Route::get('/finduser', 'UserController@search');
Route::post('/avatar', 'UserController@uploadAvatar');
