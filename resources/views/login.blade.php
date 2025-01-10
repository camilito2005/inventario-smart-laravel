{{-- $mensaje = $_REQUEST["mensaje"];
if (empty($mensaje)) {
    $mensaje = "";
} --}}
@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous"> --}}
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<script src="https://kit.fontawesome.com/d6ecbc133f.js" crossorigin="anonymous"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script> --}}
<!--<link rel="stylesheet" href="../../css/cargando.css">-->
{{-- <link rel="stylesheet" href="../css/login.css"> --}}
<!--<script src="../js/cargando.js"></script>-->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inicia Sesión</title>
<style>
</style>
</head>

<body>


<!--<div id="loading">Cargando...</div>-->
<p class="mensaje"></p>
<div class="mx-auto contenedor">
    <div class="formulario_registro">
        <form id="myForm" class="mx-auto" action="./login.php?accion=login" onsubmit="showLoading()" method="post">
            <h2 class="text-center text-secondary">Bienvenido</h2>
            <p class="text-center text-secondary">Inicia sesión</p>
            <input class="form-control" placeholder="Correo" required type="text" name="correo">
            <br>
            <input class="form-control" placeholder="Contraseña" required type="password" name="contraseña">
            <br>
            <input class="btn btn-primary" name="inicio" type="submit" value="Entrar">
            <br>
            <a class="link-recuperar" href="../vistas/usuarios.php?accion=recuperar">¿Olvidaste tu contraseña?</a>
        </form>
    </div>
</div>
<form id="myForm" action="{{route('formulario')}}" onsubmit="showLoading()" method="get">
    <button class="btn btn-outline-secondary" value="inicio">
        <i class="fa-solid fa-user-plus"></i> Agregar usuarios
    </button>
</form>
<form id="myForm" action="{{route('principal')}}" onsubmit="showLoading()" method="get">
    <button class="btn btn-outline-secondary" value="inicio">
        <i class="fa-solid fa-house"></i> Inicio
    </button>
</form>
</body>

</html>
@endsection
