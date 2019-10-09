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


Route::group(['middleware' => 'guest'], function () {
    //Landing Page
    Route::get('/', 'LandingPageController@showLandingPage');
    Route::get('unauth/', 'LandingPageController@showLandingPage')->name('login');

    Route::post('loadingLogin/', 'Auth\LoginController@login')->name('loginForm');



});



Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::post('logout/outlook', 'OutlookController@logout')->name('logoutOutlook');

    Route::get('/proyectos', 'ProjectController@index');
    
    Route::put('/proyectos/actualizar', 'ProjectController@update');
    
    Route::post('/proyectos/guardar', 'ProjectController@store');
    
    Route::delete('/proyectos/borrar/{id}', 'ProjectController@destroy');
    
    Route::get('/proyectos/buscar', 'ProjectController@show');
    
    Route::get('/usuarios', 'UserController@index');
  
    Route::put('/usuarios/actualizar', 'UserController@update');
  
    Route::post('/usuarios/guardar', 'UserController@store');
  
    Route::delete('/usuarios/borrar/{id}', 'UserController@destroy');
  
    Route::get('/usuarios/buscar', 'UserController@show');
  
    Route::get('/finduser', 'UserController@search');
  
    Route::get('/gestionar-proyectos', function () {
    return view('admin.proyectos');
    });

    Route::get('/gestionar-usuarios', function () {
        return view('admin.usuarios');
    });

  
});




