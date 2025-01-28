@extends('layouts.app')
@section('content')

@if(session('mensaje'))
    @include('layouts.alert', [
        'title' => session('type') == 'Danger' ? 'Error' : 'Info',
        'message' => session('mensaje'),
        'type' => session('type'),
    ])
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <h4>Errores de Validación:</h4>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container mt-5">
    <h1 class="text-center">Perfil de Usuario</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Información del Usuario</h5>
            @if(session('nombre'))
                <p><strong>Identificador:</strong> {{ session('usuario')->id ?? $id }}</p>
                <p><strong>Cédula:</strong> {{ session('usuario')->dni ?? $dni}}</p>
                <p><strong>Nombre:</strong> {{ session('usuario')->nombre ?? $nombre }}</p>
                <p><strong>Apellido:</strong> {{ session('usuario')->apellido ?? $apellido }}</p>
                <p><strong>Teléfono:</strong> {{ session('usuario')->telefono ?? $telefono}}</p>
                <p><strong>Dirección:</strong> {{ session('usuario')->direccion ?? $direccion}}</p>
                <p><strong>Correo:</strong> {{ session('usuario')->correo ?? $correo}}</p>
            @else
                <p>Los datos del usuario no están disponibles.</p>
            @endif
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
        <form action="{{ route('actualizar.perfil',$id) }}" method="POST" class="modal-content">
            @csrf
            @method('put')
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', session('nombre') ?? $nombre) }}" required>
                </div>
                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" value="{{ old('apellido', session('apellido')) }}" required>
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono', session('telefono')) }}" required>
                </div>
                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" value="{{ old('direccion', session('direccion')) }}" required>
                </div>
                <div class="mb-3">
                    <label for="correo" class="form-label">Correo</label>
                    <input type="email" class="form-control" id="correo" name="correo" value="{{ old('correo', session('correo')) }}" required>
                </div>
                <div class="mb-3">
                    <label for="contraseña" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder="Dejar en blanco para no cambiar">
                </div>
                <div class="mb-3">
                    <label for="cargo" class="form-label">Cargo</label>
                    @if(session('nombre') && session('descripcion') == 'administrador')
                        <select class="form-select" name="cargo" required>
                            @foreach ($cargos as $cargo)
                                <option value="{{ $cargo->id }}" {{ old('cargo', $rol) == $cargo->id ? 'selected' : '' }}>{{ $cargo->descripcion }}</option>
                            @endforeach
                        </select>
                    @else
                        <input type="text" class="form-control" value="{{ $rol }}" disabled>
                        <input type="hidden" name="cargo" value="{{ $cargo }}">
                    @endif
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
    <a href="{{ route('principal') }}" class="btn btn-outline-secondary">Volver al inicio</a>
</div>
@endsection
