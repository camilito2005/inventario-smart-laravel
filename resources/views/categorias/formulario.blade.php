@extends('layouts.app')
@section('content')
@push('estilos')
<link href="{{ asset('css/formularioCategorias.css') }}" rel="stylesheet">
@endpush
   
<body>
    <!-- Notificación de mensaje -->
    @if (session('mensaje'))
        @include('layouts.alert', [
            'title' => session('type') == 'Danger' ? 'Error' : 'Info',
            'message' => session('mensaje'),
            'type' => session('type'),
        ])
    @endif

    <!-- Usuario actual -->
    <div class="container mt-3">
        <div class="d-flex justify-content-between align-items-center">
            <span>Usuario: <strong>{{ $usuarioActual }}</strong></span>
            <a href="{{ route('cerrar') }}" class="btn btn-danger btn-sm">Cerrar sesión</a>
        </div>
    </div>

    <!-- Formulario -->
    <div class="container col-md-6 form-container">
        <h4 class="form-title">Registro de Categorías</h4>
        <form action="{{ route('ingresarCategorias') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de la categoría</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <button type="submit" class="btn btn-primary">
                Registrar
            </button>
        </form>
        <a href="{{ route('Categorias') }}" class="btn btn-secondary mt-3">
            Ver Categorías
        </a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection