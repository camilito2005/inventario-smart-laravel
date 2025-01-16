<?php

// namespace App\Models;

// use HasFactory;

// protected $table = 'roles';

// protected $fillable = [
//     'descripcion',
// ];

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = 'roles'; // Nombre de la tabla en la base de datos
    protected $fillable = ['descripcion']; // Columnas que se pueden asignar de forma masiva
}