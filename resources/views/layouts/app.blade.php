<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario SmartInfo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                    @auth
                        <li class="nav-item">
                            <span class="nav-link text-white">Hola, {{ auth()->user()->name }}</span>
                        </li>
                        <li class="nav-item">
                            <form action="#" method="POST" style="display: inline;">
                                @csrf
                                <button class="btn btn-danger nav-link" type="submit">Cerrar Sesión</button>
                            </form>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Perfil</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('Login')}}">Login</a>
                        </li>
                    @endauth
                    <li class="nav-item"><a class="nav-link active" href="{{ route('principal') }}">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Productos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Categorías</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Movimientos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Reportes</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('formulario') }}">Usuarios</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-5">
        @yield('content')
    </main>

    <footer class="bg-primary text-white text-center py-3">
        <p class="mb-0">&copy; 2024 Inventario SmartInfo. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
