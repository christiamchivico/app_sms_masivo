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
//Redireccion a Logueo
Route::get('/', function () {
    return Redirect::to(route('Home'));
});

// Logueo Usuario
Route::get('/login', ['as'=>'login', 'uses'=>'Auth\LoginController@showLoginForm']);
Route::post('/login', ['as'=>'Ingreso', 'uses'=>'Auth\LoginController@login']);

//Deslogueo
Route::get('/logout', ['as'=>'Logout', 'uses'=>'Auth\LoginController@logout']);

//Registro Nuevo Usuario
Route::get('/register', ['as'=>'register', 'uses'=>'Auth\RegisterController@showRegistrationForm']);
Route::post('/register', ['as'=>'Registrar', 'uses'=>'Auth\RegisterController@register']);

//Pagina Principal
Route::get('/home', ['as'=>'Home', 'uses'=>'HomeController@index']);

// Modulo Usuario
Route::get('/list_user', ['as'=>'list_user', 'uses'=>'UsersController@list']);
Route::get('/list_users_ajax', ['as'=>'list_user_ajax', 'uses'=>'UsersController@getUsersAjax']);
Route::get('/create_user', ['as'=>'create_user', 'uses'=>'UsersController@create']);
Route::post('/new_user', ['as'=>'new_user', 'uses'=>'UsersController@new']);

// Modulo Campaña
Route::get('/create_campana', ['as'=>'create_campana', 'uses'=>'TabCampanaController@create']);
Route::get('/new_campana', ['as'=>'new_campana', 'uses'=>'TabCampanaController@new']);
Route::get('/list_campanas', ['as'=>'list_campanas', 'uses'=>'TabCampanaController@list']);
Route::get('/list_campanas_ajax', ['as'=>'list_campanas_ajax', 'uses'=>'TabCampanaController@getCampanasAjax']);
Route::get('/edit_campana/{id}', ['as'=>'edit_campana', 'uses'=>'TabCampanaController@edit']);


// Modulo Publico
Route::get('/create_publico/{idCampana}', ['as'=>'create_publico', 'uses'=>'TabPublicoObjetivoController@create']);
Route::post('/new_publico', ['as'=>'new_publico', 'uses'=>'TabPublicoObjetivoController@new']);


/*Route::resource('catCategoriaCampanas', 'CatCategoriaCampanaController');

Route::resource('catSexos', 'CatSexoController');

Route::resource('catTipoCampanas', 'CatTipoCampanaController');

Route::resource('relCampanaPublicos', 'RelCampanaPublicoController');

Route::resource('relUsuarioEmpresas', 'RelUsuarioEmpresaController');

Route::resource('relUsuarioCampanas', 'RelUsuarioCampanaController');

Route::resource('relUsuarioPublicos', 'RelUsuarioPublicoController');

//Route::resource('tabCampanas', 'TabCampanaController');

Route::resource('tabEmpresas', 'TabEmpresaController');

Route::resource('tabFechaEnvios', 'TabFechaEnvioController');

//Route::resource('tabPublicoObjetivos', 'TabPublicoObjetivoController');

Route::resource('tabResultadoMailings', 'TabResultadoMailingController');

Route::resource('tabResultadoSms', 'TabResultadoSmsController');

#Route::get('/getToken', 'UsersController@getTokenPersonal');

Route::resource('tabPublicoInfs', 'TabPublicoInfController');

Route::resource('catSegmentacionPublicos', 'CatSegmentacionPublicoController');

Route::resource('relUsersCampanas', 'RelUsersCampanaController');

Route::resource('relUsersEmpresas', 'RelUsersEmpresaController');

Route::resource('users', 'UsersController');

Route::resource('relTipCampanas', 'RelTipCampanaController');

Route::resource('tabResultadoSmsDets', 'TabResultadoSmsDetController');*/
