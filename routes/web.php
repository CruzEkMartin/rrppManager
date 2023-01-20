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


Route::group(['namespace' => '\App\Http\Controllers'], function () {
    Route::get('/usuarios', 'UsuarioController@index')->name('Usuarios.Index');
    Route::get('/usuarios/nuevo', 'UsuarioController@create')->name('Usuarios.Nuevo');
    Route::post('/usuarios/nuevo', 'UsuarioController@store')->name('Usuarios.Guardar');
    Route::get('/usuarios/editar/{id}', 'UsuarioController@edit')->name('Usuarios.Editar');
    Route::post('/usuarios/editar/{id}', 'UsuarioController@update')->name('Usuarios.Update');
});
