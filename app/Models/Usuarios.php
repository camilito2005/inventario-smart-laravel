<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    use HasFactory;

    protected $tabla = 'usuarios';
    
    protected $fillable = [
        'dni',
        'rol',
        'nombre',
        'apellido',
        'telefono',
        'direccion',
        'correo',
        'contraseña',
    ];

}
