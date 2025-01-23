<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Usuarios;
use App\Models\Roles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;


class usuariosController extends Controller
{
    public function Index (){
        return view('principal');
    }
    public function Login_html (){
        return view('usuarios/Login');
    }
    public function Formulario (){
        $roles = Roles::all(['id', 'descripcion']);
        return view('usuarios/formulario', compact('roles'));
    }
    public function FormularioRestablecer (){
        return view('usuarios/correorestablecer');
    }
    public function resetformu() {
        return view('usuarios/reset');
    }
    
    public function Guardar(Request $request){
        $validacion = $request->validate([
            'dni' => 'required|numeric',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|numeric',
            'direccion' => 'required|string|max:255',
            'correo' => 'required|email',
            'contraseña' => 'required|min:6|confirmed',
            'rol' => 'required|numeric|exists:roles,id', // Asegura que el rol exista en la tabla `roles`
        ],
        [
            'dni.required' => 'El campo DNI es obligatorio.',
            'dni.numeric' => 'El DNI debe ser un número.',
            'dni.unique' => 'El DNI ya está registrado.',
            'contraseña.required' => 'La contraseña es obligatoria.',
            'contraseña.min' => 'La contraseña debe ser mayor a 6 caracteres.',
            'contraseña.confirmed' => 'Las contraseñas no coinciden.',
        ]);

    // dd($validacion);

        try {
            // Inserta el usuario en la base de datos
            $consulta = DB::table('usuarios')->insert([
                'dni' => $request->dni,
                'nombre' => htmlspecialchars($request->nombre),
                'apellido' => htmlspecialchars($request->apellido),
                'telefono' => htmlspecialchars($request->telefono),
                'direccion' => htmlspecialchars($request->direccion),
                'correo' => filter_var($request->correo, FILTER_SANITIZE_EMAIL),
                'contraseña' => Hash::make($request->contraseña), // Hash de la contraseña
                'fecha_ingreso' => now(),
                'rol_id' => $request->rol,
            ]);

            if ($consulta) {
                return redirect()->route('Mostrar')->with(['mensaje' =>'Usuario registrado correctamente.']);
            }
            else {
                return redirect()->route('formulario')->with(['mensaje'=> 'Hubo un error al registrar el usuario: ']);
            }
        } catch (\Exception $e) {

            return redirect()->route('formulario')->with(['mensaje', 'Hubo un error al registrar el usuario: ' . $e->getMessage()]);
        }
    }

    public function MostrarU(Request $request){
        if (!session()->has('nombre')) {
            return redirect()->route('Login_html')->with([
                'mensaje' => 'Inicia sesión para continuar.',
                'type' => 'Warning',
            ]);
        }
        // if (!session()->has('nombre')) {
        //     return redirect()->route('Login_html')->with('mensaje', 'Inicia sesión para continuar');
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

     return view('usuarios/Mostrar', compact(
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
        
        $mensaje = session(['mensaje'=> ' editar']);

        $usuario = Usuarios::findOrfail($id);

        $cargos = Roles::all(['id', 'descripcion']);

        return view('usuarios/edit', compact('usuario', 'cargos', 'mensaje'));
    }
    public function ActualizarU(Request $request, $id){
        
    // Validación
    $request->validate([
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'telefono' => 'required|numeric',
        'direccion' => 'required|string|max:255',
        'correo' => 'required|email|max:255',
        'contraseña' => 'required|string|min:6',
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
    return redirect()->route('Mostrar', $usuario->id)->with(['mensaje'=> 'Usuario actualizado exitosamente.']);
}

public function EliminarU($id)
{
    try {

        // Ejecuta la consulta de eliminación
        $deleted = DB::table('usuarios')->where('id', $id)->delete();

        // Redirecciona dependiendo del resultado
        if ($deleted) {
            return redirect()->route('Mostrar')->with(['mensaje'=> "El registro con ID $id fue eliminado correctamente."]);
        } else {
            return redirect()->route('Mostrar')->with(['mensaje'=> "Ocurrió un error al intentar eliminar el registro con ID $id."]);
        }
    } catch (\Exception $e) {
        // Manejo de excepciones
        return redirect()->route('Mostrar')->with(['mensaje'=> "Error: " . $e->getMessage()]);
    }
}

public function Login(Request $request)
{
    // Validar los datos del formulario
    $validatedData = $request->validate([
        'correo' => 'required|email',
        'contraseña' => 'required|string',
    ]);

    // Obtener las credenciales del formulario
    $correo = $request->input('correo');
    $contraseña = $request->input('contraseña');

    // Consultar la base de datos para validar el usuario
    $user = DB::table('usuarios')
        ->where('correo', $correo)
        ->first();

    if ($user && Hash::check($contraseña, $user->contraseña)) {
        // Consultar la descripción del rol
        $rol = DB::table('roles')
            ->where('id', $user->rol_id)
            ->first();

        if (!$rol) {
            return redirect()->route('Login_html')->with('mensaje', 'Rol no encontrado.');
            // return "rol no encontrado";
        }

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
            'descripcion' => $rol->descripcion,
            'rol_id' => $user->rol_id,
        ]);

        // Redirigir según el rol del usuario
        if ($user->rol_id == 1) { // Administrador
            return redirect()->route('Mostrar')->with(['mensaje'=>'Inicio de sesión exitoso.', 'type'=>'success']);
        } elseif ($user->rol_id == 2) { // Empleado
            return redirect()->route('Mostrar')->with(['mensaje' => 'Inicio de sesión exitoso.']);
        } else {
            return redirect()->route('Login_html')->with(['mensaje'=> 'Rol no reconocido.']);
        }
    } else {
        return redirect()->route('Login_html')->with(['mensaje' => 'Correo o contraseña incorrectos.']);
    }
}
public function Logout(Request $request)
{
    // Eliminar todas las sesiones del usuario
    $request->session()->flush();

    return redirect()->route('Login_html')->with(['mensaje' => 'Sesión cerrada correctamente.']);
}
public function mostrarPerfil()
{
    $id = session('id');
    $nombre = session('nombre');
    $dni = session('dni');
    $apellido = session('apellido');
    $telefono = session('telefono');
    $direccion = session('direccion');
    $correo = session('correo');
    $contraseña = session('contraseña');
    $rol = session('descripcion');


    $cargos = DB::table('roles')->get();

    if ($nombre) {
        // Obtener el rol asociado al usuario desde la tabla `roles`
        return view('usuarios/perfil', compact('id', 'dni', 'nombre', 'apellido', 'telefono', 'direccion', 'correo', 'contraseña', 'rol','cargos'));
    }
    else {
        return redirect()->route('Login_html')->with('mensaje', 'Inicia sesión para continuar.');
    }
}
public function ActualizarPerfil(Request $request)
{
    // Obtener el ID del usuario autenticado
    $id = Auth::id();

    // Validación
    $request->validate([
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'telefono' => 'required|numeric',
        'direccion' => 'required|string|max:255',
        'correo' => [
            'required',
            'email',
            'max:255',
            Rule::unique('usuarios', 'correo')->ignore($id),
        ],
        'contraseña' => 'nullable|string|min:6',
        'cargo' => 'required|exists:roles,id',
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
        'rol_id' => $request->cargo,
    ]);

    if ($usuario) {
        return redirect()->route('Mostrar')->with(['mensaje' => 'Perfil actualizado exitosamente.', 'type' => 'info' , 'title' => 'actualizacion de perfil']);
    } else {
        return redirect()->route('perfildeusuarios')->with(['mensaje' => 'Hubo un error al actualizar el perfil. Intenta nuevamente.', 'type' => 'danger' , 'title' => 'error al modificar']);
    }
}
public function requestReset(Request $request)
{
    $request->validate(['correo' => 'required|email']);

    $correo = $request->correo;
    $token = bin2hex(random_bytes(32));
    $horaExpiracion = Carbon::now()->addHour();

    // Guardar en la tabla `password_reset`
    DB::table('password_reset')->insert([
        'correo' => $correo,
        'token' => $token,
        'expires_at' => $horaExpiracion,
    ]);

    $resetLink = route('reset.form', ['token' => $token]);


    try {
        // Enviar correo electrónico
        Mail::raw(
            "Para restablecer tu contraseña, haz clic en el siguiente enlace: $resetLink",
            function ($message) use ($correo) {
                $message->to($correo)
                    ->subject('Restablecer Contraseña');
            }
        );

        return redirect()->back()->with([
            'mensaje' => 'Hemos enviado un enlace para restablecer tu contraseña. Revisa tu correo electrónico.',
        ]);
    } catch (\Exception $e) {
        // Manejar errores de envío de correo
        return redirect()->back()->withErrors([
            'mensaje' => 'Hubo un error al enviar el correo: ' . $e->getMessage(),
        ]);
    }
}

    public function resetForm($token)
    {
        $reset = DB::table('password_reset')
            ->where('token', $token)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$reset) {
            return redirect()->route('Login_html')->with(['mensaje'=> 'El enlace ha expirado o es inválido.']);
        }

        return view('usuarios/restablecer', ['token' => $token]);
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $token = $request->token;
        $password = $request->password;

        $reset = DB::table('password_reset')
            ->where('token', $token)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$reset) {
            return redirect()->route('Login_html')->with('mensaje', 'El enlace de restablecimiento no es válido o ha expirado.');
        }

        // Actualizar contraseña del usuario
        $consulta = DB::table('usuarios')
            ->where('correo', $reset->correo)
            ->update(['contraseña' => Hash::make($password)]);

            
        // Eliminar el token usado
        DB::table('password_reset')->where('token', $token)->delete();

        if(!$consulta){
            return redirect()->route('Login_html')->with('mensaje', 'Hubo un error al restablecer la contraseña.');
        }
        elseif ($consulta) {
            return redirect()->route('Login_html')->with('mensaje', 'Tu contraseña ha sido actualizada con éxito.');
            # code...
        }

    }
}
