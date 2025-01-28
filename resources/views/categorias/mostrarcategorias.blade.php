@extends('layouts.app')

@section('content')

@if (session('mensaje'))

@include('layouts.alert', [
    'title' => session('type') == 'Danger' ? 'Error' : 'Info',
    'message' => session('mensaje'),
    'type' => session('type'),
])
@endif
    <div class="container mt-4">
        <h3 class="text-center text-secondary">Categorías</h3>

        <!-- Barra de búsqueda -->
        <div class="row mb-4">
            <div class="col-md-6">
                <input type="search" id="search" class="form-control" placeholder="Buscar...">
            </div>
        </div>

        <!-- Tabla de categorías -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        {{-- <th>ID</th> --}}
                        <th>Nombre</th>
                        @if(session('nombre') && session('descripcion') == 'administrador')
                        <th>Acciones</th>
                        @else
                        @endif
                    </tr>
                </thead>
                <tbody id="resultados-equipos">
                    @forelse ($categorias as $category)
                        <tr>
                            {{-- <td>{{ $category->categoria_id }}</td> --}}
                            <td>{{ $category->nombre }}</td>
                            @if(session('nombre') && session('descripcion') == 'administrador')
                                <td>
                                    <a href="{{ route('Categorias.formularioeditar' ,$category->categoria_id) }}" class="btn btn-sm btn-primary">Modificar</a>
                                    <form action="{{ route('Categorias.eliminar',$category->categoria_id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta categoría?')">Eliminar</button>
                                    </form>
                                </td>
                            @else

                            @endif  
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No hay categorías registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Botones de navegación -->
        <div class="text-center my-4">
            @if(session('nombre') && session('descripcion') == 'administrador')
                <a href="{{ route('Formulario.categorias') }}" class="btn btn-outline-secondary">Agregar Categoría</a>
            @else
            @endif
                <a href="{{ route('principal') }}" class="btn btn-outline-secondary">Volver al inicio</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Script de búsqueda (implementación personalizada)
        $(document).on('input', '#search', function () {
            const value = $(this).val().toLowerCase();
            $('tbody#resultados-equipos tr').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
    </script>
@endsection