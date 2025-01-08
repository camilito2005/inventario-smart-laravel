<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuarios;
use Illuminate\Support\Facades\DB;

class usuariosController extends Controller
{
    public function IngresarU(){
        // return view('formulario');
    }
    public function MostrarU(Request $request){
        if (!session()->has('nombre')) {
            // return redirect()->route('login')->with('mensaje', 'Inicia sesión para continuar');
        }
        $mensaje = $request->input('mensaje', '');
        $usuario_actual = session('nombre');

         // Paginación y filtros
         $usuariosPorPagina = 10;
         $paginaActual = $request->input('pagina', 1);
         $filtroCargo = $request->input('cargo', null);

         $query = DB::table('usuarios')
         ->join('roles', 'usuarios.rol_id', '=', 'roles.id')
         ->select('usuarios.*', 'roles.descripcion as rol');

     if ($filtroCargo) {
         $query->where('usuarios.rol_id', $filtroCargo);
     }

     $totalUsuarios = $query->count();
     $usuarios = $query->limit($usuariosPorPagina)
         ->offset(($paginaActual - 1) * $usuariosPorPagina)
         ->get();

     $totalPaginas = ceil($totalUsuarios / $usuariosPorPagina);

     // Lista de roles para filtro
     $roles = DB::table('roles')->get();

     return view('usuarios.index', compact(
        'usuarios',
        'mensaje',
        'usuario_actual',
        'roles',
        'filtroCargo',
        'totalPaginas',
        'paginaActual'
    ));
    }
}