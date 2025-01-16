<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use Illuminate\Support\Facades\DB;


class DispositivosController extends Controller
{
    public function Formulario(){
        $categorias = Categoria::all();

        return view('formularioD', compact('categorias'));
    }

    public function Ingresar(Request $request)
    {
        $validated = $request->validate([
            'dispositivo_marca' => 'required|string|max:255',
            'dispositivo_modelo' => 'required|string|max:255',
            'dispositivo_ram' => 'required|string|max:255',
            'dispositivo_procesador' => 'required|string|max:255',
            'dispositivo_almacenamiento' => 'required|string|max:255',
            'dispositivo_perifericos' => 'required|string|max:255',
            'dispositivo_nombre' => 'required|string|max:255',
            'dispositivo_direccion_mac' => 'required|string|max:255',
            'observacion' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,categoria_id',
            'dispositivo_contraseña' => 'required|string|max:255',
        ]);

        $query = DB::table('dispositivos')
            ->insert([
                'dispositivo_marca' => $validated['dispositivo_marca'],
                'dispositivo_modelo' => $validated['dispositivo_modelo'],
                'dispositivo_ram' => $validated['dispositivo_ram'],
                'dispositivo_procesador' => $validated['dispositivo_procesador'],
                'dispositivo_almacenamiento' => $validated['dispositivo_almacenamiento'],
                'dispositivo_perifericos' => $validated['dispositivo_perifericos'],
                'dispositivo_nombre_usuario' => $validated['dispositivo_nombre'],
                'dispositivo_direccion_mac' => $validated['dispositivo_direccion_mac'],
                'observacion' => $validated['observacion'],
                'categoria_id' => $validated['categoria_id'],
                'dispositivo_contraseña' => $validated['dispositivo_contraseña'],
            ]);

        if ($query) {
            return redirect()->route('Mostrar')->with('success', 'Equipo registrado exitosamente.');
        } else {
            return redirect()->route('Formulario.dispositivos')->with('error', 'Ocurrió un error al registrar el equipo.');
        }
        // Aquí podrías guardar el equipo en la base de datos.
        // Por ejemplo:
        // Equipo::create($validated);

        // return redirect()->route('equipos.create')->with('success', 'Equipo registrado exitosamente.');
        // return "exito";
    }

    public function MostrarEquipos(Request $request)
    {
        $mensaje = $request->query('mensaje', '');
        $filtroCategorias = $request->query('categoria');
        $registrosPorPagina = 10;

        // Obtener categorías
        $categorias = DB::table('categorias')->select('categoria_id', 'nombre')->get();

        // Consulta base para equipos
        $query = DB::table('dispositivos')
            ->join('categorias', 'dispositivos.categoria_id', '=', 'categorias.categoria_id')
            ->select(
                'dispositivos.dispositivo_id as id',
                'dispositivos.dispositivo_nombre_usuario as nombre',
                'dispositivos.dispositivo_marca as marca',
                'dispositivos.dispositivo_modelo as modelo',
                'dispositivos.dispositivo_ram as ram',
                'dispositivos.dispositivo_procesador as procesador',
                'dispositivos.dispositivo_almacenamiento as almacenamiento',
                'dispositivos.dispositivo_direccion_mac as dir_mac',
                'dispositivos.dispositivo_perifericos as perifericos',
                'dispositivos.observacion',
                'dispositivos.dispositivo_contraseña as contraseña',
                'categorias.nombre as categoria_descripcion'
            )->orderBy('dispositivos.dispositivo_id', 'asc');

        if ($filtroCategorias) {
            $query->where('dispositivos.categoria_id', '=', $filtroCategorias);
        }

        // Paginación
        $equipos = $query->paginate($registrosPorPagina);

        return view('MostrarE', compact('mensaje', 'categorias', 'equipos', 'filtroCategorias'));
    }
}
