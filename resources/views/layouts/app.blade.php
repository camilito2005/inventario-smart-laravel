<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titulo ?? 'Inventario' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/menu.css')}}">
    @stack('estilos')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('principal') }}">Inventario SmartInfo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if (session('nombre'))
                        <li class="nav-item nav-link">¡Bienvenido {{ session('nombre') ?? 'Usuario no definido' }}</li>
                        {{-- <li class="nav-item">
                            <form action="{{ route('perfildeusuarios') }}" method="GET" style="display: inline;">
                                @csrf
                                <button class="nav-link btn btn-link p-0" type="submit">Perfil</button>
                            </form>
                        </li> --}}
                        <li class="nav-item">
                            <form action="{{ route('cerrar') }}" method="POST" style="display: inline;">
                                @csrf
                                <button class="btn btn-danger nav-link" type="submit">Cerrar Sesión</button>
                            </form>
                        </li>
                    @else 
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('Login_html') }}">Login</a>
                        </li>
                    @endif

                    <li class="nav-item"><a class="nav-link active" href="{{ route('principal') }}">Inicio</a></li>
                    
                    <!-- Submenú de Productos -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="productosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Productos
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="productosDropdown">
                            <li><a class="dropdown-item" href="{{ route('Mostrar.dispositivos') }}">Mostrar Productos</a></li>
                            <li><a class="dropdown-item" href="{{ route('Categorias') }}">Categorías</a></li>
                            <li><a class="dropdown-item" href="">Movimientos</a></li>
                        </ul>
                    </li>

                    <!-- Submenú de Usuarios -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="usuariosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Usuarios
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="usuariosDropdown">
                            <li><a class="dropdown-item" href="{{ route('Mostrar') }}">Ver Usuarios</a></li>
                            <li><a class="dropdown-item" href="{{route('formulario')}}">Ingresar Usuarios</a></li>
                            @if(session('nombre'))
                            <li class="nav-item">
                                <form action="{{ route('perfildeusuarios') }}" method="GET" style="display: inline;">
                                    @csrf
                                    <button  class="dropdown-item" type="submit">Perfil de usuario</button>
                                </form>
                            </li>
                            @else
                            @endif
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="reportesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            reportes
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="reportesDropdown">
                            <li><a class="dropdown-item" href="{{ route('estadisticas.equiposxmarcas') }}">Equipos por marcas</a></li>
                            <li><a class="dropdown-item" href="{{route('estadisticas')}}">estadisticas</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <div class="container my-4">
        @yield('contenido')
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
