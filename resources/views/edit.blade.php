<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/d6ecbc133f.js" crossorigin="anonymous"></script>
    <title>Modificar Usuario</title>
    
</head>
<body>
        
    @endpush
    @if (session('mensaje'))
    @include('layouts.alert', [
        'title' => session('type') == 'Danger' ? 'Error' : 'Info',
        'message' => session('mensaje'),
        'type' => session('type'),
    ])
@endif
    <div class="container col-md-6 col-lg-5 mt-5">
        <h3 class="form-title">Modificar Registro de Usuario</h3>
        <form action="{{ route('actualizar', $usuario->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Documento</label>
                <input type="text" class="form-control" disabled value="{{ $usuario->dni }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Nombres</label>
                <input type="text" class="form-control" name="nombre" value="{{ $usuario->nombre }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Apellidos</label>
                <input type="text" class="form-control" name="apellido" value="{{ $usuario->apellido }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input type="number" class="form-control" name="telefono" value="{{ $usuario->telefono }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Dirección</label>
                <input type="text" class="form-control" name="direccion" value="{{ $usuario->direccion }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Correo</label>
                <input type="email" class="form-control" name="correo" value="{{ $usuario->correo }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="contraseña">
            </div>
            <div class="mb-3">
                <label class="form-label">Cargo</label>
                <select class="form-control" name="cargo_id">
                    @foreach($cargos as $cargo)
                        <option value="{{ $cargo->id }}" {{ $cargo->id == $usuario->rol_id ? 'selected' : '' }}>
                            {{ $cargo->descripcion }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">
                <i class="fa-solid fa-pen"></i> Modificar
            </button>
        </form>
        <a href="{{ route('Mostrar') }}" class="btn btn-outline-secondary mt-3 w-100">
            <i class="fa-solid fa-backward"></i> Regresar
        </a>
    </div>
</body>
</html>
