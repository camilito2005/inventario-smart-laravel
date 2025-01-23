<?php

use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\DispositivosController;
use App\Http\Controllers\usuariosController;
use Illuminate\Support\Facades\Route;



Route::get('/',[usuariosController::class, 'Index'])->name('principal');

Route::get('/login', [usuariosController::class, 'Login_html'])->name('Login_html');

Route::get('usuarios/Login', [usuariosController::class, 'Login'])->name('Login');

Route::get('/formulario',[usuariosController::class, 'Formulario'])->name('formulario');

Route::get('/perfil',[usuariosController::class,'mostrarPerfil'])->name('perfildeusuarios');

Route::put('/perfil/actualizar',[usuariosController::class,'ActualizarPerfil'])->name('actualizar.perfil');

Route::put('/IngresarUsuarios',[usuariosController::class, 'Guardar'])->name('Usuarios.ingresar');

Route::put('/ingreU',[usuariosController::class, 'Guardar'])->name('ingresar');

Route::get('/MostrarUsuarios',[usuariosController::class, 'MostrarU'])->name('Mostrar');

Route::get('/EditarUsuarios/{id}',[usuariosController::class, 'EditarU'])->name('edit');

Route::put('/usuarios/{id}', [usuariosController::class, 'ActualizarU'])->name('actualizar');

Route::delete('/usuarios/{id}',[usuariosController::class, 'EliminarU'])->name('eliminar');

Route::get('/usuarios/enviarcorreo',[usuariosController::class, 'FormularioRestablecer'])->name('formulariocorreo');

Route::post('/usuarios/RecuperarContraseña',[usuariosController::class, 'requestReset'])->name('restablecer');

Route::get('/usuarios/reset/{token}', [usuariosController::class, 'resetForm'])->name('reset.form');

Route::post('/usuarios/reset', [usuariosController::class, 'resetPassword'])->name('update');

Route::post('/cerrarsesion',[usuariosController::class, 'Logout'])->name('cerrar');

Route::get('/Categorias',[CategoriasController::class, 'MostrarCategorias'])->name('Categorias');

Route::get('/Categorias/formulario', [CategoriasController::class, 'formularioCategorias'])->name('Formulario.categorias');

Route::post('/categorias/ingresar', [CategoriasController::class, 'ingresarCategorias'])->name('ingresarCategorias');

Route::get('Categorias/Formularioeditar/{id}',[CategoriasController::class, 'FormularioEdit'])->name('Categorias.formularioeditar');

Route::put('/Categorias/actualizar/{id}',[CategoriasController::class, 'updateCategory'])->name('Actualizarcategorias');

Route::delete('/categorias/eliminar/{id}',[CategoriasController::class,'Eliminar'])->name('Categorias.eliminar');

Route::get('Equipos/formulario',[DispositivosController::class, 'Formulario'])->name('Formulario.dispositivos');

Route::post('Equipos/Ingresar',[DispositivosController::class,'Ingresar'])->name('Ingresar.dispositivos');

Route::get('Equipos/Mostrar',[DispositivosController::class, 'MostrarEquipos'])->name('Mostrar.dispositivos');

Route::get('Equipos/actualizar/{id}',[DispositivosController::class, 'editar'])->name('FormularioEditar.dispositivos');

// Route::put('Equipos/{id}',[DispositivosController::class. 'update'])->name('dispositivos.actualizar');

Route::put('Equipos/{id}', [DispositivosController::class, 'update'])->name('dispositivos.actualizar');

Route::delete('Equipos/{id}',[DispositivosController::class, 'Eliminar'])->name('dispositivos.eliminar');

Route::post('Equipos/ExportarPdf',[DispositivosController::class, 'generarPDF'])->name('dispositivos.pdf');

Route::post('Equipos/ExportarExcel',[DispositivosController::class, 'generarExcel'])->name('dispositivos.excel');

Route::get('Equipos/buscar',[DispositivosController::class, 'buscar'])->name('dispositivos.buscar');