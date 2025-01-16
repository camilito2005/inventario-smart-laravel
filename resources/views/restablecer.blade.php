@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="../css/enviar_correo.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/d6ecbc133f.js" crossorigin="anonymous"></script>
    
    <!-- Custom CSS -->
    <style>
    </style>
</head>
<body>
    @if (session('mensaje'))
    @include('layouts.alert', [
        'title' => session('type') == 'Danger' ? 'Error' : 'Info',
        'message' => session('mensaje'),
        'type' => session('type'),
    ])
@endif
    <!--<div id="loading">Cargando...</div>-->
    
    <div class="container d-flex flex-column align-items-center justify-content-center vh-100">
        <div class="contenedor">
            <h2 class="text-center text-primary">Restablecer Contraseña</h2>
            <p class="text-center text-muted">
                Introduce tu correo electrónico para recibir un enlace de restablecimiento.
            </p>
            <form id="myForm" action="../vistas/usuarios.php?accion=correo_enviado" onsubmit="showLoading()" method="post">
                @csrf
                <div class="mb-3">
                    <input class="form-control" id="correo" placeholder="Correo electrónico" required type="email" name="correo">
                </div>
                <div class="d-grid">
                    <button class="btn btn-primary" type="submit">
                        Enviar
                    </button>
                </div>
            </form>
        </div>
        
        <div class="mt-3 d-flex flex-column">
            <form id="myForm" action="{{route('Login_html')}}" onsubmit="showLoading()" method="get">
                @csrf 
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="">Regresar</i> 
                </button>
            </form>
            
            <form id="myForm" action="{{route('principal')}}" onsubmit="showLoading()" method="get">
                @csrf
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="fa-solid fa-house"></i> Inicio
                </button>
            </form>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    
    <!-- Custom JS -->
    <script>
        function showLoading() {
            document.getElementById('loading').style.display = 'flex';
        }
    </script>
</body>

</html>
@endsection