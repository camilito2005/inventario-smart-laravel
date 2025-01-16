<?php

use App\Http\Controllers\Dispositivos;
use App\Http\Controllers\DispositivosController;
use App\Http\Controllers\usuariosController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[usuariosController::class, 'Index'])->name('principal');

Route::get('/login', [usuariosController::class, 'Login_html'])->name('Login_html');//IngresarU

Route::post('/Login', [usuariosController::class, 'Login'])->name('Login');

Route::get('/formulario',[usuariosController::class, 'Formulario'])->name('formulario');

Route::post('/IngresarUsuarios',[usuariosController::class, 'IngresarU'])->name('Usuarios.ingresar');

Route::get('/MostrarUsuarios',[usuariosController::class, 'MostrarU'])->name('Mostrar');

Route::get('/EditarUsuarios/{id}',[usuariosController::class, 'EditarU'])->name('edit');

Route::put('/usuarios/{id}', [usuariosController::class, 'ActualizarU'])->name('actualizar');

Route::get('/RecuperarContraseña',[usuariosController::class, 'FormularioRestablecer'])->name('restablecer');

Route::get('Equipos/formulario',[DispositivosController::class, 'Formulario'])->name('Formulario.dispositivos');

Route::post('Equipos/Ingresar',[DispositivosController::class,'Ingresar'])->name('Ingresar.dispositivos');

Route::get('Equipos/Mostrar',[DispositivosController::class, 'MostrarEquipos'])->name('Mostrar');
// Route::get('IngresarEquipos',[DispositivosController::class, '']->name('formulario.dispositivos') );
// Route::get('/Usuarios--',[usuariosController::class, 'MostrarU'])->name('Mostrar');
