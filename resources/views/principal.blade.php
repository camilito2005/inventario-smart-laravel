{{-- @extends('layouts.app')
@section('content') --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario SmartInfo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>  
    @include('layouts.menu')
    <header class="bg-light text-center py-5">
        <div class="container">
            <h1 class="display-4">Bienvenido al Inventario SmartInfo</h1>
            <p class="lead">Gestiona tus productos de manera fácil y eficiente.</p>
            <a href="" class="btn btn-primary btn-lg">Explorar Inventario</a>
        </div>
    </header>
    <div class="container my-5">
        <div class="row">
            <!-- Productos -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Productos</h5>
                        <p class="card-text">Añade, edita o elimina productos de tu inventario.</p>
                        <a href="#" class="btn btn-primary">Gestionar</a>
                    </div>
                </div>
            </div>
            <!-- Categorías -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Categorías</h5>
                        <p class="card-text">Organiza tus productos por categorías y subcategorías.</p>
                        <a href="#" class="btn btn-primary">Explorar</a>
                    </div>
                </div>
            </div>
            <!-- Movimientos -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Movimientos</h5>
                        <p class="card-text">Registra entradas y salidas de productos.</p>
                        <a href="#" class="btn btn-primary">Registrar</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- Reportes -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Reportes</h5>
                        <p class="card-text">Genera reportes detallados sobre tu inventario.</p>
                        <a href="#" class="btn btn-primary">Ver Reportes</a>
                    </div>
                </div>
            </div>
            <!-- Usuarios -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Usuarios</h5>
                        <p class="card-text">Gestiona roles y permisos para el sistema.</p>
                        <a href="{{route('Mostrar')}}" class="btn btn-primary">Administrar</a>
                    </div>
                </div>
            </div>
            <!-- Alertas -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Alertas</h5>
                        <p class="card-text">Revisa productos con stock bajo.</p>
                        <a href="#" class="btn btn-primary">Ver Alertas</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- Buscador -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Buscador</h5>
                        <p class="card-text">Encuentra productos rápidamente utilizando filtros avanzados.</p>
                        <a href="#" class="btn btn-primary">Buscar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @include('layouts.footer')
</body>
</html>
{{-- 
@endsection --}}
