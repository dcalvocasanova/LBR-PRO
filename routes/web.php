<?php
/*
|--------------------------------------------------------------------------
| Web Routes - VIEWS ROUTES
|--------------------------------------------------------------------------
| Routes related to render views according to each section of the web site.
*/

/*CONFIGURACIÓN Y SEGURIDAD RUTAS PARA REGISTRO*/
Auth::routes(
  ['login' => true,'logout' => true,'register' => false,'verify'=>false]
);

/*PAGINA DE INICIO : LOGIN*/
Route::get('/', function () {
    return view('welcome');
});

/*PERFIL DEL USUARIO*/
Route::get('/perfil-usuario', function () {
    return view('user.profile');
})->middleware('auth');

/*DASHBOARD*/
Route::get('/home', 'HomeController@index')->name('home');

/*--------------------------------------------------------------------------
| CONFIGURACIÓN DEL SISTEMA
|--------------------------------------------------------------------------*/

//PAGINA DE INICIO
Route::get('/gestionar-variables-del-sistema', function () {
    return view('containers.organizadorTareasDelSistema');
})->middleware('permission:CRUD_users|CRUD_catalogs');

//USUARIOS DEL SISTEMA
Route::get('/gestionar-usuarios-del-sistema', function () {
    return view('admin.usuarios_sistema');
})->middleware('permission:CRUD_catalogs');

//CATALOGOS DEL SISTEMA
Route::get('/gestionar-catalogos', function () {
    return view('admin.catalogos');
})->middleware('permission:CRUD_catalogs');

/*--------------------------------------------------------------------------
| PROYECTOS
|--------------------------------------------------------------------------*/

//PAGINA DE INICIO
Route::get('/gestionador-proyectos', function () {
    return view('containers.organizadorDeProyectos');
})->middleware('permission:CRUD_users|CR_users|CRUD_projects|CR_projects');

// GESTIONAR PROYECTOS
Route::get('/gestionar-proyectos', function () {
    return view('admin.proyectos');
})->middleware('permission:CRUD_projects|CR_projects');

//GESTIONAR NIVELES
Route::get('/gestionar-estructura-proyecto', function () {
    return view('admin.estructuraproyecto');
})->middleware('permission:CRUD_projects');

//GESTIONAR USUARIOS
Route::get('/gestionar-usuarios', function () {
    return view('admin.usuarios');
})->middleware('permission:CRUD_users|CR_users');

//GESTIONAR ROLES DE LOS USUARIOS
Route::get('/gestionar-roles-usuarios', function () {
    return view('user.usersRoleSelector');
})->middleware('permission:CRUD_users|CR_users');

/*--------------------------------------------------------------------------
| Parametrizacion
|--------------------------------------------------------------------------*/

 /** CATÁLOGOS **/
//PAGINA DE INICIO
Route::get('/gestionador-parametrizacion-catalogos', function () {
    return view('containers.parametrizacion-catalogos');
})->middleware('permission:CRUD_catalogs');

// CATÁLOGO DE ACCIONES PARA REGISTRO DE CONDICIONES DE TRABAJO
Route::get('/gestionar-catalogos-macroprocesos', function () {
    return view('admin.catalogos_macroprocesos');
})->middleware('permission:CRUD_catalogs');

// CATÁLOGO DE ACCIONES PARA REGISTRO DE TAREAS
Route::get('/gestionar-catalogos-tareas', function () {
    return view('admin.catalogos_tareas');
})->middleware('permission:CRUD_catalogs');

//PAGINA DE INICIO
Route::get('/gestionador-parametrizacion-diseno', function () {
    return view('containers.parametrizacion-disegno');
})->middleware('permission:CRUD_catalogs');

//GESTIONAR PARAMETRIZACIÓN DEL ANÁLISIS DE CARGAS DE TRABAJO
Route::get('/gestionar-parametros', function () {
    return view('admin.parametros');
})->middleware('permission:CRUD_parameters');

//PLANTILLAS
Route::get('/gestionar-plantillas-parametros', function () {
    return view('admin.parametrosplantilla');
})->middleware('permission:CRUD_parameters');

//GESTIONAR PARAMETRIZACIÓN DEL ANÁLISIS PSICOSOCIAL
Route::get('/gestionador-parametros-analisis-psicosocial', function () {
    return view('admin.parametros_psicoanalisis');
})->middleware('permission:CRUD_parameters');

//GESTIONAR CRITERIOS DE EVALUACIÓN
Route::get('/parametrizar-criterios-evaluacion', function () {
    return view('admin.criterios_evaluacion');
})->middleware('permission:CRUD_parameters');

//GESTIONAR VARIABLES ANÁLISIS PSICOSOCIAL
Route::get('/gestionador-variables-analisis-psicosocial', function () {
    return view('admin.variables_psicoanalisis');
})->middleware('permission:CRUD_parameters');

// PLANTILLAS
Route::get('/gestionar-plantillas-analisis-psicosicial', function () {
    return view('admin.parametrosPlantillaPsicosocial');
})->middleware('permission:CRUD_parameters');

 /** OBJETIVOS **/

//GESTIONAR OBJETIVOS DE LOS NIVELES
Route::get('/gestionar-objetivos', function () {
    return view('admin.objetivos_estructura_proyecto');
})->middleware('permission:CRUD_macroprocess');

//NOTIFICAR APROBACIÓN DE OBJETIVOS
Route::get('/notificar-aprobacion-de-objetivos', function () {
    return view('admin.aprobarObjetivos');
})->middleware('permission:CRUD_macroprocess');

//REPORTE DE APROBACIÓN DE OBJETIVOS
Route::get('/reporte-envio-objetivos', function () {
    return view('reports.reporteObjetivos');
})->middleware('permission:CRUD_macroprocess');

 /** MACROPORCESOS / PROCESOS /SUBPROCESOS **/

//REGISTRAR MACROPROCESOS
Route::get('/gestionar-macros', function () {
    return view('admin.macroprocesos_estructura_proyecto');
})->middleware('permission:CRUD_macroprocess');

//FICHA DEL MACROPROCESOS
Route::get('/gestionar-macroprocesos', function () {
    return view('admin.macroprocesos');
})->middleware('permission:CRUD_macroprocess');

//REGISTRAR PROCESOS
Route::get('/gestionar-procesos', function () {
    return view('admin.procesos');
})->middleware('permission:CRUD_macroprocess');

//SUBPROCESOS
Route::get('/gestionar-subprocesos', function () {
    return view('admin.subprocesos');
})->middleware('permission:CRUD_macroprocess');

 /** FUNCIONES DE USUARIO **/

//FUNCIONES DE LOS USUARIOS
Route::get('/gestionar-funciones-usuarios', function () {
    return view('admin.usuariosFunciones');
})->middleware('permission:CRUD_users|CR_users|CRUD_macroprocess');

 /** TAREAS **/

//GESTIÓN DE TAREAS
Route::get('/gestionar-tareas', function () {
    return view('taskManager.tareas');
})->middleware('permission:CRUD_tasks');

//NOTIFICAR APROBACIÓN DE TAREAS
Route::get('/notificar-aprobacion-de-tareas', function () {
    return view('admin.aprobarTareas');
})->middleware('permission:CRUD_tasks');

//REPORTE DE APROBACIÓN DE TAREAS
Route::get('/reporte-envio-tareas', function () {
    return view('reports.reporteTareas');
})->middleware('permission:CRUD_tasks');

/*--------------------------------------------------------------------------
| ANÁLISIS PSICOSOCIAL
|--------------------------------------------------------------------------
 ES IGUAL AL QUE SALE EN PARAMETRIZACIÓN: DISEÑO DE INSTRUMENTOS, SE COLOCÓ ESTE ENLACE A PETICIÓN DEL CLIENTE
*/
//PAGINA DE INICIO
Route::get('/psicoanalisis-parametrizar', function () {
    return view('containers.psicoanalisis-disegno');
})->middleware('permission:CRUD_catalogs');

/*--------------------------------------------------------------------------
| MEDICIÓN
|--------------------------------------------------------------------------*/

//PÁGINA DE INICIO
Route::get('/medicion-analisis', function () {
    return view('containers.medicion-analisis');
})->middleware('permission:CRUD_tasks');

//GESTIONAR ELEMENTOS ASOCIADOS A TAREAS
Route::get('/gestionar-tareas-variables-adicionales', function () {
    return view('taskManager.tareas-variables-asociadas');
})->middleware('permission:CRUD_tasks');

//GESTIONAR VARIABLES DE MEDICIÓN
Route::get('/gestionar-tareas-con-variables-medicion', function () {
    return view('taskManager.tareas-variables-medicion');
})->middleware('permission:CRUD_tasks');


/*--------------------------------------------------------------------------
| REPORTES
|--------------------------------------------------------------------------*/

//POR EL MOMENTO

Route::get('/ejemplos', function () {
    return view('reports.reporteEjemplo');
});

//PENDIENTE DE REVISIÓN
Route::get('/parametrizar-tiempos-ajuste', function () {
    return view('admin.tiempo-ajuste');
})->middleware('permission:CRUD_parameters');
//
Route::get('/gestionar-tareas-con-variables-medicion', function () {
    return view('taskManager.tareas-variables-medicion');
})->middleware('permission:CRUD_tasks');
//
Route::get('/ayuda', function () {
    return view('admin.ayuda');
})->middleware('auth');

/*
|--------------------------------------------------------------------------
| Web Routes - CONTROLLER ROUTES
|--------------------------------------------------------------------------
| Routes related to access BACK-END
*/

/*Notification Controller*/
Route::get('send', 'HomeController@sendNotification')->middleware('auth');
Route::post('/notify/goal','NotificatorController@sendGoalsNotification')->middleware('auth');
Route::post('/notify/task','NotificatorController@sendTasksNotification')->middleware('auth');
Route::put('/notificaciones/aceptar','NotificatorController@markAsOk')->middleware('auth');
Route::put('/notificaciones/rechazar','NotificatorController@markAsRejected')->middleware('auth');
Route::get('/notificaciones/tareas-por-nivel','NotificatorController@getTasksByLevelNotifications')->middleware('auth');
Route::get('/notificaciones/objetivos-por-nivel','NotificatorController@getGoalsByLevelNotifications')->middleware('auth');
Route::get('/notificaciones/tareas/{id}','NotificatorController@getTasksNotifications')->middleware('auth');
Route::get('/notificaciones/objetivos/{id}','NotificatorController@getGoalsNotifications')->middleware('auth');
Route::get('/usuario/notificaciones', 'NotificatorController@allNotifications');
Route::get('/usuario/notificaciones-nuevas', 'NotificatorController@unreadNotifications');
Route::get('/notificaciones', function () {
    return view('admin.usuariosNotificaciones');
})->middleware('auth');

/*Manage Projects*/
Route::get('/proyectos', 'ProjectController@index');
Route::get('/todos-los-proyectos', 'ProjectController@getAllProjects');
Route::put('/proyectos/actualizar', 'ProjectController@update');
Route::post('/proyectos/guardar', 'ProjectController@store');
Route::delete('/proyectos/borrar/{id}', 'ProjectController@destroy');
Route::get('/proyectos/buscar', 'ProjectController@show');
Route::get('/findproject', 'ProjectController@search');
Route::get('/proyecto/productos/{id}', 'ProjectController@getProducts');
Route::get('/proyecto/actual', 'ProjectController@getCurrentProjectSession');
Route::post('/proyecto/establecer', 'ProjectController@setCurrentProjectSession');


/*Manage Catalogs*/
Route::get('/catalogo', 'CatalogController@getListCatalog');
Route::get('/catalogo/phva', 'CatalogController@getPHVACatalog');
Route::get('/catalogo/competencias', 'CatalogController@getSkillTaskCatalog');
Route::get('/catalogo/riesgos', 'CatalogController@getRiskCatalog');
Route::get('/catalogo/trabajos', 'CatalogController@getWorkTypeCatalog');
Route::post('/catalogo/guardar', 'CatalogController@storeItem');
Route::put('/catalogo/actualizar', 'CatalogController@updateItem');
Route::delete('/catalogo/borrar/{id}', 'CatalogController@deleteItem');
Route::get('/catalogo/roles', 'CatalogController@getRoles');
Route::get('/catalogo/roles-usuario', 'CatalogController@getRolesToSimpleUser');
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
Route::get('/estructura/lista-niveles/{id}', 'ProjectStructureController@getListOfProjectLevels');
Route::get('/estructura/lista-funciones-de-usuario/{id}','ProjectStructureController@getListOfUserFunctions');
Route::get('/estructura/lista-objetivos/{id}', 'ProjectStructureController@getListOfGoals');

/*Manage Users*/
Route::get('/usuarios', 'UserController@index');
Route::get('/usuarios-por-proyecto', 'UserController@getUserByProject');
Route::get('/usuarios-por-nivel', 'UserController@getUserByLevelStructure');
Route::get('/usuarios-jefes-por-nivel', 'UserController@getUserWhithRolesByLevelStructure');
Route::get('/usuario', 'UserController@getCurrentUser');
Route::get('/usuarios-plantilla', 'UserController@getExcel');
Route::get('/usuarios/del-sistema', 'UserController@getUserSystem');
Route::get('/usuarios/rol/{id}', 'UserController@getRole');
Route::any('/usuarios/loadusers', 'UserController@loadUsers');
Route::put('/usuarios/actualizar', 'UserController@update');
Route::post('/usuarios/guardar', 'UserController@store');
Route::delete('/usuarios/borrar/{id}', 'UserController@destroy');
Route::get('/usuarios/buscar/{id}', 'UserController@show');
Route::get('/finduser', 'UserController@search');
Route::post('/uploadfile', 'UserController@loadFiles');
Route::put('/usuarios/avatar-change', 'UserController@saveAvatar');
Route::put('/usuarios/password-change', 'UserController@savePassword');
Route::put('/usuarios/asignar-roles', 'UserController@updateUserRoles');

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
Route::get('/plantillas/buscarxtipo/{type}','TemplateController@getTemplatesByType');
Route::get('/plantillas/porusuario/','TemplateController@getTemplatesByUser');
Route::get('/plantillas/buscar', 'TemplateController@show');

/*Manage Parameters*/
Route::get('/criterios-evaluacion', 'CriteriaController@index');
Route::get('/criterios-evaluacion-all', 'CriteriaController@getAll');
Route::put('/criterios-evaluacion/actualizar', 'CriteriaController@update');
Route::post('/criterios-evaluacion/guardar', 'CriteriaController@store');
Route::delete('/criterios-evaluacion/borrar/{id}', 'CriteriaController@destroy');


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
Route::any('/macroprocesos/loadmacroprocess', 'MacroprocessController@loadMacroprocess');
Route::put('/macroprocesos/actualizar', 'MacroprocessController@update');
Route::post('/macroprocesos/guardar', 'MacroprocessController@store');
Route::delete('/macroprocesos/borrar/{id}', 'MacroprocessController@destroy');
Route::get('/macroprocesos/buscar', 'MacroprocessController@show');
Route::get('/macroprocesos/file', 'MacroprocessController@getMacroprocessFile');
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
Route::get('/procesos/file', 'ProcessController@getProcessFile');
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

/*Manage User's functions*/
Route::get('/funciones/{id}', 'UserFunctionController@getUserFunctionsById');
Route::put('/funciones/actualizar', 'UserFunctionController@update');
Route::post('/funciones/guardar', 'UserFunctionController@store');
Route::delete('/funciones/borrar/{id}', 'UserFunctionController@destroy');
/* Measures*/

Route::put('/measures/actualizar', 'MeasureController@update');
Route::get('/measures/usuario', 'MeasureController@getUserMeasures');

Route::put('/parameters_measures/actualizar', 'ParameterMeasureController@update');
Route::get('/parameter_measures/usuario', 'ParameterMeasureController@getUserParameterMeasures');

/*Manage Task of a project*/
Route::get('/tareas/{id}', 'TaskController@index');
Route::get('/tareas-por-tipo', 'TaskController@getTaskAccordingTypeAndLevel');
Route::put('/tareas/actualizar', 'TaskController@update');
Route::post('/tareas/guardar', 'TaskController@store');
Route::delete('/tareas/borrar/{id}', 'TaskController@destroy');
Route::post('/tareas/notificadas', 'TaskController@changeTaskStatus');
Route::get('tareas-por-usuario','TaskController@getUserTasks');

/*Manage Psychosocial Analysis*/
Route::get('/psicoanalisis', 'PsychosocialQuestionController@index');
Route::put('/psicoanalisis/actualizar', 'PsychosocialQuestionController@update');
Route::post('/psicoanalisis/guardar', 'PsychosocialQuestionController@store');
Route::delete('/psicoanalisis/borrar/{id}', 'PsychosocialQuestionController@destroy');
Route::get('/findquestion', 'PsychosocialQuestionController@search');

/*Manage Psychosocial Analysis Variables*/
Route::get('/psicoanalisis-variables', 'PsychosocialVariableController@index');
Route::put('/psicoanalisis-variables/actualizar', 'PsychosocialVariableController@update');
Route::post('/psicoanalisis-variables/guardar', 'PsychosocialVariableController@store');
Route::delete('/psicoanalisis-variables/borrar/{id}', 'PsychosocialVariableController@destroy');
Route::get('/findvariable', 'PsychosocialVariableController@search');
