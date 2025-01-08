
@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!--<link rel="stylesheet" href="../../css/cargando.css">
    <link rel="shortcut icon" href="../../fotos/agregar-usuario.png" type="image/x-icon">-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <!--<script src="../js/cargando.js"></script>-->
    {{-- <link rel="stylesheet" href="../css/ingresar_usuarios.css"> --}}
    <title>Registro de Usuarios</title>
    <style>
    </style>
</head>
<body>
@if (isset($_SESSION["nombre"]))
        <div>
        <span class="me-3">Usuario: <strong>$usuario_actual
                                    </strong>
        </span>
        <a href="../vistas/usuarios.php?accion=cerrar" class="btn btn-danger btn-sm">Cerrar sesión</a>
    </div>
@endif
<div id="loading" style="display: none;">Cargando...

</div>
{{-- <p class="mensaje">mensaje</p> --}}
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
                        
                    </div>                                          
    <div class="row">
        <div class="col s12 m8 offset-m2 l6 offset-l3">
            
            <div class="card">
                <div class="card-content">
                    <h4 class="center-align grey-text">Registro de Usuarios</h4>
                    <form id="myForm" onsubmit="showLoading()" action="" method="post">
                        
                        <div class="input-field">
                            <input id="dni" type="text" name="dni" required>
                            <label for="dni">DNI</label>
                        </div>

                        @if (isset($_SESSION['nombre']) && $_SESSION['descripcion'] === "administrador") 
                        <div class="input-field">
                            <select name="rol" required>
                                <option value="1">Administrador</option>
                                <option value="2">Usuario</option>
                            </select>
                            <label for="rol">Rol</label>
                        </div>
                        @endif
                        <div class="input-field">
                            <select name="rol" required>
                                <option value="2">Usuario</option>
                            </select>
                            <label for="rol">Rol</label>
                        </div>
                        <div class="input-field">
                            <input id="nombre" type="text" name="nombre" required>
                            <label for="nombre">Nombre</label>
                        </div>

                        <div class="input-field">
                            <input id="apellido" type="text" name="apellido" required>
                            <label for="apellido">Apellidos</label>
                        </div>

                        <div class="input-field">
                            <input id="telefono" type="tel" name="telefono" required>
                            <label for="telefono">Número Telefónico</label>
                        </div>

                        <div class="input-field">
                            <input id="direccion" type="text" name="direccion" required>
                            <label for="direccion">Dirección</label>
                        </div>

                        <div class="input-field">
                            <input id="correo" type="email" name="correo" required>
                            <label for="correo">Correo Electrónico</label>
                        </div>

                        <div class="input-field">
                            <input id="contraseña" type="password" name="contraseña" required>
                            <label for="contraseña">Contraseña</label>
                        </div>

                        <div class="input-field">
                            <input id="confirmar_contraseña" type="password" name="confirmar_contraseña" required>
                            <label for="confirmar_contraseña">Confirmar Contraseña</label>
                        </div>

                        <div class="center-align">
                            <button class="btn waves-effect waves-light" type="submit" name="registro">
                                Registrar
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-action center-align">
                    <form action="./usuarios.php?accion=ver" onsubmit="showLoading()" method="post">
                        <button class="btn-flat waves-effect">
                            <i class="material-icons left">Usuarios</i> 
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
 <div class="container">
     <div class="row">
         <div class="col s12">
             <p class="center-align">Para continuar, inicia sesión.</p>
             <div class="center-align">
                 <a href="../pagina-principal/login.php?accion=login" class="btn waves-effect waves-light">
                     Iniciar sesión
                 </a>
             </div>
         </div>
     </div>
 </div>
<div class="container center-align">
    <form action="../index.php" onsubmit="showLoading()" method="post">
        <button class="btn-flat waves-effect">
            <i class="material-icons left">Inicio</i> 
        </button>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('select');
        M.FormSelect.init(elems);
    });
</script>
</body>
</html>
@endsection