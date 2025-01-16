<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Usuarios;
use App\Models\Roles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class usuariosController extends Controller
{
    public function Index (){
        return view('principal');
    }
    public function Formulario (){
        // if (!session()->has('nombre')) {
        //     return redirect()->route('Login')->with('mensaje', 'Inicia sesión para continuar');
        // }
        return view('formulario');
    }
    public function Login_html (){
        return view('Login');
    }
    public function FormularioRestablecer (){
        return view('restablecer');
    }
    public function Depurar(Request $request){
        
        $datos = [
            "dni" => $request->input('dni'),
            "nombre" => $request->input("nombre"),
            "apellido" => $request->input("apellido"),
            "telefono" => $request->input("telefono"),
            "direccion" => $request->input("direccion"),
            "correo" => $request->input("correo"),
            "contraseña" => $request->input("contraseña"),
            "confirmar_contraseña" => $request->input("confirmar_contraseña"),
            "rol" => $request->input("rol"),
        ];
        echo "<br> dni : ".$datos['dni']."<br>";
        echo "<br> nombre : ".$datos['nombre']."<br>";
        echo "<br> apellido : ".$datos['apellido']."<br>";
        echo "<br> telefono : ".$datos['telefono']."<br>";
        echo "<br> direccion : ".$datos['direccion']."<br>";
        echo "<br> correo : ".$datos['correo']."<br>";
        echo "<br> contraseña : ".$datos["contraseña"]."<br>";
        echo "<br> comfirmar contraseña :".$datos["confirmar_contraseña"]."<br>";
        echo "<br> rol : ".$datos["rol"];

        // Validar los datos

        $validatedData = $request->validate([
            'dni' => 'required|unique:usuarios,dni',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'direccion' => 'required|string|max:255',
            'correo' => 'required|email|unique:usuarios,correo',
            'contraseña' => 'required|string|min:6|confirmed',
            'rol' => 'required|integer|exists:roles,id', // Asegúrate de tener una tabla de roles
        ]);

    }
    public function IngresarU(Request $request){


        // Validar los datos
        $validatedData = $request->validate([
          'dni' => 'required|unique:usuarios,dni',
          'nombre' => 'required|string|max:255',
          'apellido' => 'required|string|max:255',
          'telefono' => 'required|string|max:15',
          'direccion' => 'required|string|max:255',
          'correo' => 'required|email|unique:usuarios,correo',
          'contraseña' => 'required|string|min:6|confirmed',
          'rol' => 'required|integer|exists:roles,id', // Asegúrate de tener una tabla de roles
      ]);
      
      try {
          // Crear el usuario
          $user = Usuarios::create([
              'dni' => $request->input('dni'),
              'rol_id' => $request->input('rol'),
              'nombre' => $request->input('nombre'),
              'apellido' => $request->input('apellido'),
              'telefono' => $request->input('telefono'),
              'direccion' => $request->input('direccion'),
              'correo' => $request->input('correo'),
              'contraseña' => Hash::make($request->input('contraseña')), // Encriptar la contraseña
              'fecha_ingreso' => now(),
          ]);
          if ($user) {
              echo 'Usuario registrado exitosamente.';die();
          }
      } catch (QueryException $e) {
          echo 'Ocurrió un problema al registrar el usuario. Por favor, inténtelo de nuevo.';die();
      } catch (\Exception $e) {
          echo 'Algo inesperado ocurrió: ' . $e->getMessage();die();
      }
      }

    public function MostrarU(Request $request){
        // if (!session()->has('nombre')) {
        //     return redirect()->route('Login_html')->with([
        //         'mensaje' => 'Inicia sesión para continuar.',
        //         'type' => 'Warning',
        //     ]);
        // }
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
    function EditarU(Request $request ,$id){
        
        $mensaje = session('mensaje', '');

        $usuario = Usuarios::findOrfail($id);

        $cargos = Roles::all(['id', 'descripcion']);

        return view('edit', compact('usuario', 'cargos', 'mensaje'));
    }
    public function ActualizarU(Request $request, $id){
        
    // Validación
    $request->validate([
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'telefono' => 'required|numeric',
        'direccion' => 'required|string|max:255',
        'correo' => 'required|email|max:255',
        'contraseña' => 'nullable|string|min:6',
        'cargo_id' => 'required|exists:roles,id',
    ]);

    // Buscar usuario y actualizar datos
    $usuario = Usuarios::findOrFail($id);
    $usuario->update([
        'nombre' => $request->nombre,
        'apellido' => $request->apellido,
        'telefono' => $request->telefono,
        'direccion' => $request->direccion,
        'correo' => $request->correo,
        'contraseña' => $request->contraseña ? bcrypt($request->contraseña) : $usuario->contraseña,
        'rol_id' => $request->cargo_id,
    ]);

    // Redirigir con mensaje
    return redirect()->route('Mostrar', $usuario->id)
                     ->with('mensaje', 'Usuario actualizado exitosamente.');
}
    
public function EliminarU(Request $request){
    if (!session()->has('nombre')) {
        return redirect()->route('Login')->with('mensaje', 'Inicia sesión para continuar');
    }

    $id = $request->input('id');
    $usuario = User::find($id);

    if (!$usuario) {
        return redirect()->route('Mostrar')->with('error', 'Usuario no encontrado.');
    }

    try {
        $usuario->delete();
        return redirect()->route('Mostrar')->with('success', 'Usuario eliminado exitosamente.');
    } catch (QueryException $e) {
        return redirect()->route('Mostrar')->with('error', 'Ocurrió un problema al eliminar el usuario. Por favor, inténtelo de nuevo.');
    } catch (\Exception $e) {
        return redirect()->route('Mostrar')->with('error', 'Algo inesperado ocurrió: ' . $e->getMessage());
    }
}
    public function Login(Request $request){
    // Validar los datos del formulario
    $validatedData = $request->validate([
        'correo' => 'required|email',
        'contraseña' => 'required|string',
    ]);

    // Obtener las credenciales del formulario
    $correo = $request->input('correo');
    $contraseña = $request->input('contraseña');

    // Consultar la base de datos para validar el usuario
    $user = User::where('correo', $correo)->first();

    // Verifica si se encontró un resultado
    if ($user && Hash::check($contraseña, $user->contraseña)) {
        // Guardar los datos en la sesión
        session([
            'id' => $user->id,
            'dni' => $user->dni,
            'nombre' => $user->nombre,
            'apellido' => $user->apellido,
            'telefono' => $user->telefono,
            'direccion' => $user->direccion,
            'correo' => $user->correo,
            'contraseña' => $user->contraseña,
            'descripcion' => $user->rol->descripcion, // Asumiendo que tienes una relación con el modelo Rol
            'rol_id' => $user->rol_id,
        ]);

        // Redirigir según el rol del usuario
        if ($user->rol_id == 1) {  // Administrador
            return redirect()->route('usuarios.ver')->with('success', 'Inicio de sesión exitoso.');
        } elseif ($user->rol_id == 2) {  // Empleado
            return redirect()->route('usuarios.ver')->with('success', 'Inicio de sesión exitoso.');
        } else {
            return redirect()->route('Login')->with('error', 'Rol no reconocido.');
        }
    } else {
        return redirect()->route('Login')->with('error', 'Correo o contraseña incorrectos.');
    }
}
}
