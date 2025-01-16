<?php

// namespace App\Models;


// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class Usuarios extends Model
// {
//     use HasFactory;

//     protected $tabla = 'usuarios';
    
//     protected $fillable = [
//         'dni',
//         'rol',
//         'nombre',
//         'apellido',
//         'telefono',
//         'direccion',
//         'correo',
//         'contraseña',
//     ];

// }

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuarios extends Authenticatable
{
    use HasFactory;

    // Especificar la tabla 'usuarios' en lugar de 'users'
    protected $table = 'usuarios';

    protected $fillable = [
        'dni', 'nombre', 'apellido', 'telefono', 'direccion', 'correo', 'contraseña', 'fecha_ingreso', 'rol_id'
    ];

    protected $hidden = [
        'contraseña',
    ];

    //
public function updateUser($data)
{
    $this->dni = $data['dni'];
    $this->nombre = $data['nombre'];
    $this->apellido = $data['apellido'];
    $this->telefono = $data['telefono'];
    $this->direccion = $data['direccion'];
    $this->correo = $data['correo'];
    if (isset($data['password'])) {
        $this->password = bcrypt($data['password']);
    }
    $this->fecha_ingreso = $data['fecha_ingreso'];
    $this->rol_id = $data['rol_id'];
    $this->save();
}

public function deleteUser()
{
    $this->delete();
}
}


