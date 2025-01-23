@extends('layouts.app')

@section('content')
<div class="container col-md-6 col-lg-5">
    <h3 class="text-center text-primary mb-4">Modificar Registro de Equipos</h3>
    <form action="{{ route('dispositivos.actualizar', $id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{ $id }}">
        
        <div class="mb-3">
            <label class="form-label">Nombres</label>
            <input type="text" class="form-control" name="nombre" value="{{ $dispositivo->dispositivo_nombre_usuario }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Marca</label>
            <input type="text" class="form-control" name="marca" value="{{ $dispositivo->dispositivo_marca }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Modelo</label>
            <input type="text" class="form-control" name="modelo" value="{{ $dispositivo->dispositivo_modelo }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Ram</label>
            <input type="text" class="form-control" name="ram" value="{{ $dispositivo->dispositivo_ram }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Procesador</label>
            <input type="text" class="form-control" name="procesador" value="{{ $dispositivo->dispositivo_procesador }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Almacenamiento</label>
            <input type="text" class="form-control" name="almacenamiento" value="{{ $dispositivo->dispositivo_almacenamiento }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Direccion Mac</label>
            <input type="text" class="form-control" name="dir_mac" value="{{ $dispositivo->dispositivo_direccion_mac }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Perifericos</label>
            <input type="text" class="form-control" name="perifericos" value="{{ $dispositivo->dispositivo_perifericos }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Observación</label>
            <input type="text" class="form-control" name="observacion" value="{{ $dispositivo->observacion }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Categoria</label>
            <select name="categoria" class="form-select">
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->categoria_id }}" {{ $dispositivo->categoria_id == $categoria->categoria_id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="text" class="form-control" name="contraseña" value="{{ $dispositivo->dispositivo_contraseña }}">
        </div>
        <button type="submit" class="btn btn-primary w-100">Modificar</button>
    </form>
    <div class="mt-3">
        <a href="{{ route('Mostrar.dispositivos') }}" class="btn btn-outline-secondary w-100">Regresar</a>
    </div>
</div>
@endsection
