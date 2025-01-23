<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispositivos extends Model
{
    use HasFactory;

    protected $table = 'dispositivos'; // Nombre de la tabla

    protected $primaryKey = 'dispositivo_id';
    
    protected $fillable = [
            'dispositivo_marca',
            'dispositivo_modelo',
            'dispositivo_ram',
            'dispositivo_procesador',
            'dispositivo_almacenamiento',
            'dispositivo_perifericos',
            'dispositivo_nombre',
            'dispositivo_direccion_mac',
            'observacion',
            'categoria_id',
            'dispositivo_contraseña',
    ];
}
