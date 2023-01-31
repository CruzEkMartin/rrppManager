<?php

use Illuminate\Support\Facades\Route;

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
    return view('principal');

    //ACA VA LA VALIDACION DE SI SE HA INICIADO SESION

    //     if (session()->has('periodo')) {

    //         if (session('periodo') <= 2) {
    //              return redirect('/registro2020');
    //         } elseif(session('periodo') == 3) {
    //             return redirect('/registro');
    //         } else {
    //           return redirect('/2022/registro');
    //         }
    //    } else {
    //         return redirect('/2022/registro');
    //    }


});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/usuarios','\UsuarioController@index')->name('usuarios');

//*********catalogo de usuarios */
Route::group(['namespace' => '\App\Http\Controllers'], function () {
    Route::get('/usuarios', 'UsuarioController@index')->name('Usuarios.Index');
    Route::get('/usuarios/nuevo', 'UsuarioController@create')->name('Usuarios.Nuevo');
    Route::post('/usuarios/nuevo', 'UsuarioController@store')->name('Usuarios.Guardar');
    Route::get('/usuarios/editar/{id}', 'UsuarioController@edit')->name('Usuarios.Editar');
    Route::put('/usuarios/editar/{id}', 'UsuarioController@update')->name('Usuarios.Update');
});


//*********catalogo de sectores */
Route::group(['namespace' => '\App\Http\Controllers'], function () {
    Route::get('/sectores', 'SectoresController@index')->name('Sectores.Index');
    Route::get('/sectores/nuevo', 'SectoresController@create')->name('Sectores.Nuevo');
    Route::post('/sectores/nuevo', 'SectoresController@store')->name('Sectores.Guardar');
    Route::get('/sectores/editar/{id}', 'SectoresController@edit')->name('Sectores.Editar');
    Route::put('/sectores/editar/{id}', 'SectoresController@update')->name('Sectores.Update');
});


//*********catalogo de categorias */
Route::group(['namespace' => '\App\Http\Controllers'], function () {
    Route::get('/categorias', 'CategoriasController@index')->name('Categorias.Index');
    Route::get('/categorias/nuevo', 'CategoriasController@create')->name('Categorias.Nuevo');
    Route::post('/categorias/nuevo', 'CategoriasController@store')->name('Categorias.Guardar');
    Route::get('/categorias/editar/{id}', 'CategoriasController@edit')->name('Categorias.Editar');
    Route::put('/categorias/editar/{id}', 'CategoriasController@update')->name('Categorias.Update');
});

//*********catalogo de partidos */
Route::group(['namespace' => '\App\Http\Controllers'], function () {
    Route::get('/partidos', 'PartidosController@index')->name('Partidos.Index');
    Route::get('/partidos/nuevo', 'PartidosController@create')->name('Partidos.Nuevo');
    Route::post('/partidos/nuevo', 'PartidosController@store')->name('Partidos.Guardar');
    Route::get('/partidos/editar/{id}', 'PartidosController@edit')->name('Partidos.Editar');
    Route::put('/partidos/editar/{id}', 'PartidosController@update')->name('Partidos.Update');
});


//*********Contactos */
Route::group(['namespace' => '\App\Http\Controllers'], function () {
    Route::get('/contactos', 'ContactosController@index')->name('Contactos.Index');
    Route::get('/contactos/ver/{id}', 'ContactosController@show')->name('Contactos.Ver');
    Route::get('/contactos/nuevo', 'ContactosController@create')->name('Contactos.Nuevo');
    Route::post('/contactos/nuevo', 'ContactosController@store')->name('Contactos.Guardar');
    Route::get('/contactos/editar/{id}', 'ContactosController@edit')->name('Contactos.Editar');
    Route::put('/contactos/editar/{id}', 'ContactosController@update')->name('Contactos.Update');
});


//*********AJAX */
Route::group(['namespace' => '\App\Http\Controllers'], function () {
    Route::post('/obtenerCategorias', 'QueriesController@obtenerCategorias')->name('Queries.ObtenerCategorias');
    Route::post('/obtenerMunicipios', 'QueriesController@obtenerMunicipios')->name('Queries.ObtenerMunicipios');
    Route::post('/obtenerLocalidades', 'QueriesController@obtenerLocalidades')->name('Queries.ObtenerLocalidades');
    Route::post('/verContacto', 'QueriesController@obtenerContacto')->name('Queries.ObtenerContacto');
    Route::post('/borrarFotoContacto', 'QueriesController@borrarFotoContacto')->name('Queries.BorrarFotoContacto');
    Route::delete('/contactos/eliminar', 'QueriesController@borraContacto')->name('Queries.EliminaContacto');
});
