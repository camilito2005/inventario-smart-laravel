<?php

use App\Http\Controllers\usuariosController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[usuariosController::class, 'Index'])->name('principal');

Route::get('/Login', [usuariosController::class, 'Login_html'])->name('Login');;//IngresarU
Route::get('/formularios',[usuariosController::class, 'Formulario'])->name('formulario');

Route::post('/IngresarUsuarios',[usuariosController::class, 'IngresarU'])->name('Ingresar');
Route::get('/MostrarUsuarios',[usuariosController::class, 'MostrarU'])->name('Mostrar');
Route::post('/EditarUsuarios',[usuariosController::class, 'MostrarU'])->name('edit');
// Route::get('/Usuarios--',[usuariosController::class, 'MostrarU'])->name('Mostrar');
