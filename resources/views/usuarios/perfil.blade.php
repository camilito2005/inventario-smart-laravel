@extends('layouts.app')
@section('content');

@if(session('mensaje'))
@include('layouts.alert', [
    'title' => session('type') == 'Danger' ? 'Error' : 'Info',
    'message' => session('mensaje'),
    'type' => session('type'),
])
@endif

@include('layouts.alert', [
    'title' => session('type') == 'Danger' ? 'Error' : 'Info',
    'message' => session('mensaje'),
    'type' => session('type'),
])
    <div class="container mt-5">
        <h1 class="text-center">Perfil de Usuario</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Información del Usuario</h5>
                    <p><strong>Cargo/Rol:</strong> {{  $rol }}</p>
                    <p><strong>Identificador:</strong> {{ $id }}</p>
                    <p><strong>Cédula:</strong> {{ $dni }}</p>
                    <p><strong>Nombre:</strong> {{ $nombre }}</p>

                    <p><strong>Apellido:</strong> {{ $apellido }}</p>
                    <p><strong>Teléfono:</strong> {{ $telefono }}</p>
                    <p><strong>Dirección:</strong> {{ $direccion }}</p>
                    <p><strong>Correo:</strong> {{ $correo }}</p>
                    <div class="d-flex justify-content-between mt-3">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">Editar</button>
                        <form action="{{ route('cerrar') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Cerrar sesión</button>
                        </form>
                    </div>
            </div>
        </div>
    </div>

    <!-- Modal de Edición -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{route('actualizar.perfil')}}" method="POST" class="modal-content">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Editar Perfil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $nombre }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" value="{{ $apellido }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $telefono }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" value="{{ $direccion }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="correo" name="correo" value="{{ $correo }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="contraseña" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder="Dejar en blanco para no cambiar">
                        </div>
                        <div class="mb-3">
                            <label for="cargo" class="form-label">Cargo</label>
                            <select class="form-select" name="cargo" required>
                                @foreach ($cargos as $cargo)
                                    <option value="{{ $cargo->id }}" {{ $cargo->id == $rol ? 'selected' : '' }}>{{ $cargo->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Guardar cambios</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="text-center my-4">
            <a href="{{ route('formulario') }}" class="btn btn-outline-secondary">Agregar Usuario</a>
        </div>

        <div class="text-center">
            <a href="{{route('principal')}}" class="btn btn-outline-secondary">Volver al inicio</a>
        </div>
@endsection
