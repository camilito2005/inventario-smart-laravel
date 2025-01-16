@extends('layouts.app')
@section('content')
@section('titulo', 'Registro de Usuarios')

@if (isset($_SESSION["nombre"]))
    <div class="alert alert-primary text-center" role="alert">
        Usuario: <strong>{{ $usuario_actual }}</strong>
        <a href="" class="btn btn-danger btn-sm ms-3">Cerrar sesión</a>
    </div>
@endif
<x-alert type="Success">
    <x-slot name="title">
        Registro de Usuarios        
    </x-slot>
    por favor sirve para algo 
</x-alert>
@include('layouts.alert', ['title' => 'Registro de Usuarios', 'message' => 'error al intentar ingresar'] , ['type' => 'Danger'])
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Registro de Usuarios</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('Usuarios.ingresar') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="dni" class="form-label">DNI</label>
                            <input type="text" class="form-control" id="dni" name="dni" required>
                        </div>
                        <div class="mb-3">
                            <label for="rol" class="form-label">Rol</label>
                            <select class="form-select" id="rol" name="rol" required>
                                @if (isset($_SESSION['nombre']) && $_SESSION['descripcion'] === "administrador")
                                    <option value="1">Administrador</option>
                                @endif
                                <option value="2" selected>Usuario</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Número Telefónico</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" required>
                        </div>
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required>
                        </div>
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="correo" name="correo" required>
                        </div>
                        <div class="mb-3">
                            <label for="contraseña" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="contraseña" name="contraseña" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmar_contraseña" class="form-label">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="confirmar_contraseña" name="confirmar_contraseña" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary w-100">Registrar</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('Mostrar') }}" class="btn btn-link">Ver Usuarios</a>
                    <a href="{{ route('principal') }}" class="btn btn-link">Volver al Inicio</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
