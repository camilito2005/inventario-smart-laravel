<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuarios;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class usuariosController extends Controller
{
    public function Index (){
        return view('principal');
    }
    public function Formulario (){
        return view('formulario');
    }
    public function Login_html (){
        return view('Login');
    }
    public function IngresarU(Request $request){
  // Validar los datos
  $request->validate([
    'dni' => 'required|string|max:10|unique:usuarios,dni',
    'rol' => 'required|integer|in:1,2', // 1: Administrador, 2: Usuario
    'nombre' => 'required|string|max:255',
    'apellido' => 'required|string|max:255',
    'telefono' => 'required|string|max:15',
    'direccion' => 'required|string|max:255',
    'correo' => 'required|email|unique:usuarios,correo',
    'contraseña' => 'required|string|min:8|same:confirmar_contraseña',
]);

try {
    // Crear el usuario
    $usuario = Usuarios::create([
        'dni' => $request->input('dni'),
        'rol' => $request->input('rol'),
        'nombre' => $request->input('nombre'),
        'apellido' => $request->input('apellido'),
        'telefono' => $request->input('telefono'),
        'direccion' => $request->input('direccion'),
        'correo' => $request->input('correo'),
        'contraseña' => Hash::make($request->input('contraseña')), // Encriptar la contraseña
    ]);

    // Redirigir si se inserta correctamente
    // return redirect()->route('Mostrar')->with('success', 'Usuario registrado exitosamente.');
     return  'Usuario registrado exitosamente.';
} catch (QueryException $e) {
    // Manejar errores de base de datos
    // return redirect()->back()->withErrors(['error' => 'Ocurrió un problema al registrar el usuario. Por favor, inténtelo de nuevo.']);
    return  'Ocurrió un problema al registrar el usuario. Por favor, inténtelo de nuevo.';
} catch (\Exception $e) {
    // Manejar cualquier otro error
    // return redirect()->back()->withErrors(['error' => 'Algo inesperado ocurrió: ' . $e->getMessage()]);
     return 'Algo inesperado ocurrió';
}   }

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

     return view('Mostrar', compact(
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