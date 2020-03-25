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

/*
* Grant access only for users with CRUD_users permission
*/
Route::get('/gestionar-actividades', function () {
    return view('containers.activities');
})->middleware('permission:CRUD_users|CRUD_projects|CR_projects|CRUD_catalogs');

/*
* Grant access only for users with CRUD_users permission
*/
Route::get('/gestionador-proyectos', function () {
    return view('containers.projectManager');
})->middleware('permission:CRUD_users|CR_users|CRUD_projects|CR_projects|CRUD_catalogs');


/*
* Grant access only for users with CRUD_parameters
*/
Route::get('/gestionador-parametrizacion', function () {
    return view('containers.parametrizationManager');
})->middleware('permission:CRUD_parameters');

/*
* Grant access only for users with CRUD_parameters
*/
Route::get('/parametrizar-tiempos-ajuste', function () {
    return view('admin.tiempo-ajuste');
})->middleware('permission:CRUD_parameters');

/*
* Grant access only for users with CRUD_parameters
*/
Route::get('/parametrizar-criterios-evaluacion', function () {
    return view('admin.criterios_evaluacion');
})->middleware('permission:CRUD_parameters');

/*
* Grant access only for users with CRUD_parameters
*/
Route::get('/gestionador-macroprocesos', function () {
    return view('containers.macroprocessManager');
})->middleware('permission:CRUD_macroprocess');

/*
* Grant access only for users with CRUD_users permission
*/
Route::get('/gestionar-usuarios', function () {
    return view('admin.usuarios');
})->middleware('permission:CRUD_users|CR_users');

/*
* Grant access only for users with CRUD_users permission
*/
Route::get('/gestionar-usuarios-del-sistema', function () {
    return view('admin.usuarios_sistema');
})->middleware('permission:CRUD_catalogs');
/*
* Grant access only for users with CRUD_projects permission
*/
Route::get('/gestionar-proyectos', function () {
    return view('admin.proyectos');
})->middleware('permission:CRUD_projects|CR_projects');
/*
* Grant access only for users with CRUD_catalogs permission
*/
Route::get('/gestionar-catalogos', function () {
    return view('admin.catalogos');
})->middleware('permission:CRUD_catalogs');
/*
* Grant access only for users with CRUD_catalogs permission
*/
Route::get('/gestionar-catalogos-macroprocesos', function () {
    return view('admin.catalogos_macroprocesos');
})->middleware('permission:CRUD_catalogs');


/*
* Grant access only for users with CRUD_task
*/
Route::get('/gestionar-tareas', function () {
    return view('taskManager.tareas');
})->middleware('permission:CRUD_tasks');


Route::group(['middleware' => ['permission:CRUD_parameters']], function () {
  Route::get('/gestionar-parametros', function () {
      return view('admin.parametros');
  });
  Route::get('/gestionar-plantillas-parametros', function () {
      return view('admin.parametrosplantilla');
  });
  Route::get('/gestionar-estructura-proyecto', function () {
      return view('admin.estructuraproyecto');
  });
  Route::get('/gestionar-calendario', function () {
      return view('admin.calendarios');
  });
  Route::get('/gestionar-tree', function () {
      return view('admin.tree');
  });
});
Route::group(['middleware' => ['permission:CRUD_macroprocess']], function () {
  Route::get('/gestionar-macroprocesos', function () {
      return view('admin.macroprocesos');
  });
  Route::get('/gestionar-procesos', function () {
      return view('admin.procesos');
  });
  Route::get('/gestionar-subprocesos', function () {
      return view('admin.subprocesos');
  });
  Route::get('/gestionar-objetivos', function () {
      return view('admin.objetivos_estructura_proyecto');
  });
});
Route::group(['middleware' => ['permission:CRUD_tasks']], function () {});
Route::group(['middleware' => ['permission:R_reports']], function () {});

Route::get('/ayuda', function () {
    return view('admin.ayuda');
})->middleware('auth');

Route::get('/notificaciones', function () {
    return view('admin.usuariosNotificaciones');
})->middleware('auth');

/*
*EJEMPLO
*/

Route::get('/notificador', function () {
    return view('admin.ejemploNotificacion');
})->middleware('auth');

Route::get('/perfil-usuario', function () {
    return view('user.profile');
})->middleware('auth');

Auth::routes();
Auth::routes(['register' => false, 'verify'=>true]);

Route::get('send', 'HomeController@sendNotification')->middleware('auth');
Route::post('sender', 'HomeController@sendNoti')->middleware('auth');

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
Route::get('/catalogo/roles', 'CatalogController@getRoles');
Route::post('/catalogo/guardar-rol', 'CatalogController@storeRole');
Route::put('/catalogo/actualizar-rol', 'CatalogController@updateRole');
Route::delete('/catalogo/borrar-rol/{id}', 'CatalogController@deleteRole');
Route::get('/catalogo/permisos-del-rol/{id}', 'CatalogController@getAllPermisssionsFromRole');
Route::post('/catalogo/guardar-permisos/{id}', 'CatalogController@updatePermisssionsFromRole');
/*Manage Project Levels Structure*/
Route::get('/estructura', 'ProjectStructureController@getProjectLevels');
Route::get('/estructura/macroprocesos', 'ProjectStructureController@getMacroprocessProject');
Route::put('/estructura/actualizar', 'ProjectStructureController@update');
Route::post('/estructura/guardar', 'ProjectStructureController@store');
Route::delete('/estructura/borrar/{id}', 'ProjectStructureController@destroy');
Route::get('/estructura/buscar', 'ProjectStructureController@show');
/*Manage Users*/
Route::get('/usuarios', 'UserController@index');
Route::get('/usuario', 'UserController@getCurrentUser');
Route::get('/usuarios-plantilla', 'UserController@getExcel');
Route::get('/usuarios/del-sistema', 'UserController@getUserSystem');
Route::get('/usuarios/rol/{id}', 'UserController@getRole');
Route::any('/usuarios/loadusers', 'UserController@loadUsers');
Route::put('/usuarios/actualizar', 'UserController@update');
Route::post('/usuarios/guardar', 'UserController@store');
Route::delete('/usuarios/borrar/{id}', 'UserController@destroy');
Route::get('/usuarios/buscar', 'UserController@show');
Route::get('/finduser', 'UserController@search');
Route::post('/uploadfile', 'UserController@loadFiles');
Route::put('/usuarios/avatar-change', 'UserController@saveAvatar');
Route::put('/usuarios/password-change', 'UserController@savePassword');
Route::get('/usuario/notificaciones', 'UserController@allNotifications');
Route::get('/usuario/notificaciones-nuevas', 'UserController@unreadNotifications');
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
Route::post('/subparametros/setsession', 'SubparameterController@session');
/*Manage Variables*/
Route::get('/variables', 'VariableController@index');
Route::get('/variables-tiempos-ajuste', 'VariableController@var_related_time');
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

/*Manage Parameters*/
Route::get('/criterios-evaluacion', 'QuestionController@index');
Route::put('/criterios-evaluacion/actualizar', 'QuestionController@update');
Route::post('/criterios-evaluacion/guardar', 'QuestionController@store');
Route::delete('/criterios-evaluacion/borrar/{id}', 'QuestionController@destroy');


/*Manage Macroprocess*/
Route::get('/macroprocesos', 'MacroprocessController@index');
Route::put('/macroprocesos/actualizar', 'MacroprocessController@update');
Route::post('/macroprocesos/guardar', 'MacroprocessController@store');
Route::delete('/macroprocesos/borrar/{id}', 'MacroprocessController@destroy');
Route::get('/macroprocesos/buscar', 'MacroprocessController@show');
Route::post('/macroprocesos/setsession', 'MacroprocessController@session');
/*Manage Levels*/
Route::get('/niveles', 'LevelController@index');
Route::put('/niveles/actualizar', 'LevelController@update');
Route::post('/niveles/guardar', 'LevelController@store');
Route::delete('/niveles/borrar/{id}', 'LevelController@destroy');
Route::get('/niveles/buscar', 'LevelController@show');
Route::post('/niveles/setsession', 'LevelController@session');
/*Manage Objectives*/
Route::get('/objetivos', 'ObjectiveController@index');
Route::put('/objetivos/actualizar', 'ObjectiveController@update');
Route::post('/objetivos/guardar', 'ObjectiveController@store');
Route::delete('/objetivos/borrar/{id}', 'ObjectiveController@destroy');
Route::get('/objetivos/buscar', 'ObjectiveController@show');
/*Manage Macroprocess*/
Route::get('/macroprocesos', 'MacroprocessController@index');
Route::get('/macroproceso', 'MacroprocessController@getCurrentMacroprocess');
Route::get('/macroprocesos-plantilla', 'MacroprocessController@getExcel');
Route::get('/macroprocesos/del-sistema', 'MacroprocessController@getMacroprocess');
Route::get('/macroprocesos/rol/{id}', 'MacroprocessController@getRole');
Route::any('/macroprocesos/loadmacroprocesos', 'MacroprocessController@loadUsers');
Route::put('/macroprocesos/actualizar', 'MacroprocessController@update');
Route::post('/macroprocesos/guardar', 'MacroprocessController@store');
Route::delete('/macroprocesos/borrar/{id}', 'MacroprocessController@destroy');
Route::get('/macroprocesos/buscar', 'MacroprocessController@show');
Route::get('/findmacroprocess', 'MacroprocessController@search');
Route::post('/uploadfile', 'MacroprocessController@loadFiles');
/*Manage Process*/
Route::get('/procesos', 'ProcessController@index');
Route::get('/proceso', 'ProcessController@getCurrentProcess');
Route::get('/procesos-plantilla', 'ProcessController@getExcel');
Route::get('/procesos/del-sistema', 'ProcessController@getProcess');
Route::get('/procesos/rol/{id}', 'ProcessController@getRole');
Route::any('/procesos/loadmacroprocesos', 'ProcessController@loadUsers');
Route::put('/procesos/actualizar', 'ProcessController@update');
Route::post('/procesos/guardar', 'ProcessController@store');
Route::delete('/procesos/borrar/{id}', 'ProcessController@destroy');
Route::get('/procesos/buscar', 'ProcessController@show');
Route::get('/findmacroprocess', 'ProcessController@search');
Route::post('/uploadfile', 'ProcessController@loadFiles');
/*Manage Subprocess*/
Route::get('/subprocesos', 'SubprocessController@index');
Route::get('/subproceso', 'SubprocessController@getCurrentSubprocess');
Route::get('/subprocesos-plantilla', 'SubprocessController@getExcel');
Route::get('/subprocesos/del-sistema', 'SubprocessController@getSubprocess');
Route::get('/subprocesos/rol/{id}', 'SubprocessController@getRole');
Route::any('/subprocesos/loadmacroprocesos', 'SubprocessController@loadUsers');
Route::put('/subprocesos/actualizar', 'SubprocessController@update');
Route::post('/subprocesos/guardar', 'SubprocessController@store');
Route::delete('/subprocesos/borrar/{id}', 'SubprocessController@destroy');
Route::get('/subprocesos/buscar', 'SubprocessController@show');
Route::get('/findmacroprocess', 'SubprocessController@search');
Route::post('/uploadfile', 'SubprocessController@loadFiles');

