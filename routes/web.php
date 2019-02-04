<?php

Auth::routes();

// van antes de los resource, sino no toma la ruta
Route::get('/registros/load', 'RegistrosController@Excel')->name('registros.load');
Route::get('/registros/search', 'RegistrosController@search')->name('registros.search');

Route::get('/', 'HomeController@index')->name('main');
Route::get('/home', 'HomeController@index');

Route::get('/dispositivos/download/{dispositivo}', 'DispositivosController@download')->name('dispositivos.download');
Route::get('trabajas/horarios/{id}', 'TrabajasController@getHorarios');
Route::get('licencia/{id}','LicenciasController@getDiasLicencia');
Route::get('tipolicencia/{id}','LicenciasController@getTiposLicencia');

Route::post('/reportes/horasTrabajadasEmpleado', 'ReportesController@horasTrabajadasEmpleado')->name('reportes.horasTrabajadasEmpleado');
Route::post('/reportes/llegadasTarde', 'ReportesController@llegadasTarde')->name('reportes.llegadasTarde');
Route::post('/reportes/salidasAntes', 'ReportesController@salidasAntes')->name('reportes.salidasAntes');
Route::post('/reportes/horasNocturnas', 'ReportesController@horasNocturnas')->name('reportes.horasNocturnas');
Route::post('/reportes/horasExtras', 'ReportesController@horasExtras')->name('reportes.horasExtras');
Route::post('/reportes/listadoFaltas', 'ReportesController@listadoFaltas')->name('reportes.listadoFaltas');
Route::post('/reportes/entradasYsalidas', 'ReportesController@entradasYsalidas')->name('reportes.entradasYsalidas');
Route::post('/reportes/libresConcedidos', 'ReportesController@libresConcedidos')->name('reportes.libresConcedidos');
Route::post('/registros/load/excel', 'RegistrosController@loadExcel')->name('registros.loadExcel');
Route::post('/search', 'AuditsController@search')->name('audits.search');
Route::get('/flush', 'AuditsController@flush')->name('audits.flush');




Route::resource('menus', 'MenusController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('users', 'UsersController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('modulos', 'ModulosController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('perfils', 'PerfilsController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('permisos', 'PermisosController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('empresas', 'EmpresasController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('sucursals', 'SucursalsController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('dispositivos', 'DispositivosController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('oficinas', 'OficinasController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('sesions', 'SesionsController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('logs', 'LogsController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('ajustes', 'AjustesController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('autorizacions', 'AutorizacionsController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('feriados', 'FeriadosController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('conversacions', 'ConversacionsController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('mensajes', 'MensajesController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('tipo_horarios', 'TipoHorariosController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('tipo_empleados', 'TipoEmpleadosController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('tipo_licencias', 'TipoLicenciasController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('licencias', 'LicenciasController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('empleados', 'EmpleadosController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('registros', 'RegistrosController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('horario_semanals', 'HorarioSemanalsController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('horarios', 'HorariosController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('turnos', 'TurnosController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('horario_rotativos', 'HorarioRotativosController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('trabajas', 'TrabajasController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('licencia_detalles', 'LicenciaDetallesController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('reportes', 'ReportesController',['only' => ['index', 'horasTrabajadasEmpleado']]);
Route::resource('audits', 'AuditsController', ['only' => ['index', 'show', 'search']]);


Route::resource('tipo_libres', 'TipoLibresController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('libre_detalles', 'LibreDetallesController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);

