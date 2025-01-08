<?php

use App\Http\Controllers\usuariosController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('principal');
});

Route::get('/Login',function (){
    // return 'formulario';
});//IngresarU
Route::get('/usuarios',function(){
    // return view('formulario');
    return "algo";
});
Route::get('/Mostrar',[usuariosController::class, 'MostrarU'])->name('Mostrar.mostrarU');
