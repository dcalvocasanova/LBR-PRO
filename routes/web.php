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

Route::get('/gestionar-macroprocesos', function () {
    return view('admin.macroprocesos');
});

Route::get('/gestionar-plantillas-parametros', function () {
    return view('admin.parametrosplantilla');
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
Route::post('/uploadfile', 'UserController@loadFiles');

/*Manage Parameters*/
Route::get('/parametros', 'ParameterController@index');
Route::put('/parametros/actualizar', 'ParameterController@update');
Route::post('/parametros/guardar', 'ParameterController@store');
Route::delete('/parametros/borrar/{id}', 'ParameterController@destroy');
Route::get('/parametros/buscar', 'ParameterController@show');
Route::post('/parametros/setsession', 'ParameterController@session');
Route::get('/parametros/cargatrabajo', 'ParameterController@getWorkLoadCategory');
Route::get('/parametros/psicosocial', 'ParameterController@getPsychosocialCategory');


/*Manage SubParameters*/
Route::get('/subparametros', 'SubparameterController@index');
Route::put('/subparametros/actualizar', 'SubparameterController@update');
Route::post('/subparametros/guardar', 'SubparameterController@store');
Route::delete('/subparametros/borrar/{id}', 'SubparameterController@destroy');
Route::get('/subparametros/buscar', 'SubparameterController@show');
Route::get('/subparametros/buscarxid/{id}','SubparameterController@getSubParametersByParameterId');
Route::post('/subparametros/setsession', 'SubParameterController@session');

/*Manage Variables*/
Route::get('/variables', 'VariableController@index');
Route::put('/variables/actualizar', 'VariableController@update');
Route::post('/variables/guardar', 'VariableController@store');
Route::delete('/variables/borrar/{id}', 'VariableController@destroy');
Route::get('/variable/buscarxid/{id}','VariableController@getVariablesBySubParameterId');
Route::get('/variables/buscar', 'VariableController@show');


/*Manage Template*/
Route::get('/plantillas', 'TemplateController@index');
Route::put('/plantillas/actualizar', 'TemplateController@update');
Route::post('/plantillas/guardar', 'TemplateController@store');
Route::delete('/plantillas/borrar/{id}', 'TemplateController@destroy');
Route::get('/plantillas/buscarxtipo/{type}','TemplateController@getTeplatesByType');
Route::get('/plantillas/buscar', 'TemplateController@show');
