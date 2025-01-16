@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="text-center text-secondary">Equipos</h3>

    <!-- Barra de búsqueda y filtros -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="input-group">
                <input type="search" id="search" class="form-control" placeholder="Buscar...">
            </div>
        </div>
        <div class="col-md-6">
            <form method="get" action="{{ route('Mostrar') }}">
                <select id="category-filter" name="categoria" class="form-select" onchange="this.form.submit()">
                    <option value="">Todas</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->categoria_id }}" 
                            {{ $filtroCategorias == $categoria->categoria_id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    <!-- Mensaje -->
    @if ($mensaje)
        <p class="alert alert-info">{{ $mensaje }}</p>
    @endif

    <!-- Tabla de equipos -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>RAM</th>
                    <th>Procesador</th>
                    <th>Almacenamiento</th>
                    <th>MAC</th>
                    <th>Periféricos</th>
                    <th>Observación</th>
                    <th>Categoría</th>
                    <th>Contraseña</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($equipos as $equipo)
                    <tr>
                        <td>{{ $equipo->id }}</td>
                        <td>{{ $equipo->nombre }}</td>
                        <td>{{ $equipo->marca }}</td>
                        <td>{{ $equipo->modelo }}</td>
                        <td>{{ $equipo->ram }}</td>
                        <td>{{ $equipo->procesador }}</td>
                        <td>{{ $equipo->almacenamiento }}</td>
                        <td>{{ $equipo->dir_mac }}</td>
                        <td>{{ $equipo->perifericos }}</td>
                        <td>{{ $equipo->observacion }}</td>
                        <td>{{ $equipo->categoria_descripcion }}</td>
                        <td>
                            <input type="password" class="form-control" value="{{ $equipo->contraseña }}" readonly>
                        </td>   
                        <td>
                            <a href="" class="btn btn-sm btn-primary">
                                Modificar
                            </a>
                            <a href="" onclick="return confirm('¿Estás seguro?')" class="btn btn-sm btn-danger">
                                Eliminar
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center">No hay equipos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    {{ $equipos->links() }}
</div>
@endsection
