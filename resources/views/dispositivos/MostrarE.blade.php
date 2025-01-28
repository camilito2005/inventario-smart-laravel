@extends('layouts.app')
@section('titulo')
Gestion de dispositivos
@endsection
@section('content')
@push('estilos')
<link rel="stylesheet" href="{{asset('css/paginacion.css')}}">
@endpush
@if (session('mensaje'))
    @include('layouts.alert', [
        'title' => session('type') == 'Danger' ? 'Error' : 'Info',
        'message' => session('mensaje'),
        'type' => session('type'),
    ])
@endif
<form  action="{{route('dispositivos.pdf')}}" onsubmit="showLoading()" method="POST">
    @csrf
    <button class="btn btn-success">
        <i class="fa-solid fa-file-pdf"></i> Descargar PDF
    </button>
</form>
<form  action="{{route('dispositivos.excel')}}" onsubmit="showLoading()" method="POST">
    @csrf
    <button class="btn btn-danger">
        <i class="fa-solid fa-file-excel"></i> Descargar EXCEL
    </button>
</form>
<div class="container mt-4">
    {{-- <p>{{session('nombre')}}</p> --}}
    <h3 class="text-center text-secondary">Equipos</h3>

    <!-- Barra de búsqueda y filtros -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="input-group">
                <input type="search" id="search" class="form-control" placeholder="Buscar...">
            </div>
        </div>
        <div class="col-md-6">
            <form method="get" action="{{route('Mostrar.dispositivos')}}">
                
            <input type="hidden" id="role" value="{{session('descripcion')}}">

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
                    {{-- <th>ID</th> --}}
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
                    @if(session('nombre') && session('descripcion') === "administrador")
                    <th>Acciones</th>
                    @else
                    @endif
                </tr>
            </thead>
            <tbody id="resultados-equipos">
                @forelse ($equipos as $equipo)
                    <tr>
                        {{-- <td>{{ $equipo->id }}</td> --}}
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
                        @if(session('nombre') && session('descripcion') === "administrador")
                        <td>
                            <a href="{{route('FormularioEditar.dispositivos',$equipo->id)}}" class="btn btn-sm btn-primary">
                                @method('POST')
                                Modificar
                            </a>
                            <form action="{{ route('dispositivos.eliminar',$equipo->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este dispositivo?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>

                            {{-- <a href="{{route('dispositivos.eliminar',$equipo->id)}}" onclick="return confirm('¿Estás seguro?')" class="btn btn-sm btn-danger">
                                Eliminar
                            </a> --}}
                        </td>
                        @else
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center">No hay equipos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
    @if (session('nombre') && session('descripcion') === "administrador")
    <form  action="{{route('Formulario.dispositivos')}}" method="get">
        <button class="btn btn-outline-secondary" value="inicio">
            <i class="fa-solid fa-user-plus"></i> Agregar equipos
        </button>
    </form>
    @else
    
    @endif
    <form action="{{route('principal')}}" method="get">
        <button class="btn btn-outline-secondary" value="inicio">
            <i class="fa-solid fa-house"></i> Inicio
        </button>
    </form>

    <!-- Paginación -->
    <div class="custom-pagination">
        {{ $equipos->links() }}
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    const urlBuscar = "{{ route('dispositivos.buscar') }}";
    const routeFormularioEditar = "{{ route('FormularioEditar.dispositivos', ':id') }}";
    const routeEliminar = "{{ route('dispositivos.eliminar', ':id') }}";
    const csrfToken = "{{ csrf_token() }}";
</script>
<script src="{{ asset('js/buscador.js') }}"></script>

@endsection
