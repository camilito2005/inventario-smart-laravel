@extends('layouts.app')
@section('content')
@section('titulo', 'Gestión de Usuarios')
    @if (session('mensaje'))
    @include('layouts.alert', [
        'title' => session('type') == 'Danger' ? 'Error' : 'Info',
        'message' => session('mensaje'),
        'type' => session('type'),
    ])
@endif
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="text-secondary">Gestión de Usuarios</h3>
            @if (session('nombre'))
            <div>
                <span class="me-3">Usuario: <strong>{{ $usuario_actual }}</strong></span>
                <form id="myForm" action="{{ route('cerrar') }}" method="POST">
                    @csrf
                    <button class="btn btn-danger btn-sm" type="submit">
                        <i class="fa-solid fa-house"></i> Cerrar Sesión
                    </button>
                </form>
                {{-- <a href="{{route('cerrar')}}" >Cerrar sesión</a> --}}
            </div>
            @endif
        </div>
        <div class="my-4">
            <h5 class="text-secondary">Filtrar por cargo:</h5>
            <form method="get" action="{{ route('Mostrar') }}">
                <select name="cargo" class="form-select w-50 d-inline" onchange="this.form.submit()">
                    <option value="">Todos los cargos</option>
                    @foreach ($roles as $rol)
                        <option value="{{ $rol->id }}" {{ $filtroCargo == $rol->id ? 'selected' : '' }}>
                            {{ $rol->descripcion }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
        @if($mensaje)
            <p class="alert alert-info">{{ $mensaje }}</p>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>DNI</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Correo</th>
                        <th>Cargo</th>
                        @if(session('nombre') && session('descripcion') === "administrador")
                        <th>Acciones</th>
                        @else   
                        @endif
                    </tr>
                </thead>
                <tbody id="resultados-equipos">
                    @forelse ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->id }}</td>
                            <td>{{ $usuario->dni }}</td>
                            <td>{{ $usuario->nombre }}</td>
                            <td>{{ $usuario->apellido }}</td>
                            <td>{{ $usuario->telefono }}</td>
                            <td>{{ $usuario->direccion }}</td>
                            <td>{{ $usuario->correo }}</td>
                            <td>{{ $usuario->rol }}</td>
                            @if(session('nombre') && session('descripcion') === "administrador")
                            <td>
                                <a href="{{ route('edit', $usuario->id) }}" class="btn btn-sm btn-primary">Modificar</a>
                                <form method="post" action="{{route('eliminar',$usuario->id)}}" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</button>
                                </form>
                            </td>
                            @else
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">No se encontraron usuarios.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <nav aria-label="Paginación">
            <ul class="pagination justify-content-center">
                @for ($i = 1; $i <= $totalPaginas; $i++)
                    <li class="page-item {{ $i == $paginaActual ? 'active' : '' }}">
                        <a class="page-link" href="">{{ $i }}</a>
                    </li>
                @endfor
            </ul>
        </nav>

        <div class="text-center my-4">
            <a href="{{ route('formulario') }}" class="btn btn-outline-secondary">Agregar Usuario</a>
        </div>

        <div class="text-center">
            <a href="{{route('principal')}}" class="btn btn-outline-secondary">Volver al inicio</a>
        </div>
    </div>

    <link rel="stylesheet" href="{{ asset('css/tu-archivo.css') }}">

</body>
@endsection 
