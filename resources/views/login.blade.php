@extends('layouts.app')
@section('content')
@section('titulo', 'Inicio de Sesión')
    @if (session('mensaje'))
    @include('layouts.alert', [
        'title' => session('type') == 'Danger' ? 'Error' : 'Info',
        'message' => session('mensaje'),
        'type' => session('type'),
    ])
@endif

<style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f0f2f5;
    }
    .login-container {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .login-card {
        width: 100%;
        max-width: 400px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 2rem;
    }
    .login-card h2 {
        font-weight: bold;
        color: #1877f2;
    }
    .btn-primary {
        background-color: #1877f2;
        border-color: #1877f2;
    }
    .btn-primary:hover {
        background-color: #145db2;
        border-color: #145db2;
    }
    .link-recuperar {
        display: block;
        text-align: center;
        margin-top: 1rem;
        color: #1877f2;
        text-decoration: none;
    }
    .link-recuperar:hover {
        text-decoration: underline;
    }
</style>
    <div class="login-container">
        <div class="login-card">
            <h2 class="text-center">Inicia Sesión</h2>
            {{-- <p class="text-center text-secondary">Conéctate con tus datos</p> --}}
            <form action="{{ route('Login') }}" method="post">
                @csrf
                <div class="mb-3">
                    <input type="text" name="correo" class="form-control" placeholder="Correo Electrónico" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="contraseña" class="form-control" placeholder="Contraseña" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                </div>
            </form>
            <a class="link-recuperar" href="{{ route('restablecer') }}">¿Olvidaste tu contraseña?</a>
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