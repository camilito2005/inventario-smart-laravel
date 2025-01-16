
    {{-- $consulta = <<<SQL
    SELECT categoria_id, nombre FROM categorias
SQL;
$resultado_consulta = pg_query($conexion,$consulta);
$categorias= pg_fetch_all($resultado_consulta);

    session_start();

    if (!isset($_SESSION["nombre"])) {
        header("Location: ../vistas/login.php?accion=login-html&mensaje=inicia sesion para continuar");
        exit();
    }

    $mensaje = $_REQUEST["mensaje"];
    if (empty($mensaje)) {
        $mensaje = "";
    } --}}
     @extends('layouts.app')
    @section('content')
    @section('titulo', 'Registro de Equipos')
    @push('name')
    <style>
        .form-container {
            max-width: 600px; /* Limitar el ancho del formulario */
            margin: auto; /* Centrar el formulario */
        }
    </style>    
    @endpush
    
    @if (session('mensaje'))
        <div class="alert alert-{{ session('type') == 'Danger' ? 'danger' : 'info' }} alert-dismissible fade show mx-auto" role="alert" style="max-width: 600px;">
            <strong>{{ session('type') == 'Danger' ? 'Error' : 'Info' }}</strong>: {{ session('mensaje') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container my-5 form-container">
        <div class="card">
            <div class="card-header text-center bg-primary text-white">
                <h4>Registro de Equipos</h4>
            </div>
            <div class="card-body">
                <form id="myForm" onsubmit="showLoading()" action="{{route('Ingresar.dispositivos')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre del Responsable</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="marca" class="form-label">Marca del Equipo</label>
                        <input type="text" class="form-control" id="marca" name="marca" required>
                    </div>

                    <div class="mb-3">
                        <label for="modelo" class="form-label">Modelo del Equipo</label>
                        <input type="text" class="form-control" id="modelo" name="modelo" required>
                    </div>

                    <div class="mb-3">
                        <label for="ram" class="form-label">Memoria RAM del Equipo</label>
                        <input type="text" class="form-control" id="ram" name="ram" required>
                    </div>

                    <div class="mb-3">
                        <label for="procesador" class="form-label">Procesador del Equipo</label>
                        <input type="text" class="form-control" id="procesador" name="procesador" required>
                    </div>

                    <div class="mb-3">
                        <label for="categoria" class="form-label">Filtrar por Categoría</label>
                        <select id="category-filter" class="form-select" name="categoria">
                            @foreach ($categorias as $categoria) 
                                <option value="{{ $categoria->categoria_id }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="almacenamiento" class="form-label">Almacenamiento del Equipo</label>
                        <input type="text" class="form-control" id="almacenamiento" name="almacenamiento" required>
                    </div>

                    <div class="mb-3">
                        <label for="dir-mac" class="form-label">Dirección MAC del Equipo</label>
                        <input type="text" class="form-control" id="dir-mac" name="dir-mac" required>
                    </div>

                    <div class="mb-3">
                        <label for="perifericos" class="form-label">Periféricos del Equipo</label>
                        <input type="text" class="form-control" id="perifericos" name="perifericos" required>
                    </div>

                    <div class="mb-3">
                        <label for="observacion" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="observacion" name="observacion" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="contraseña" class="form-label">Contraseña del Equipo</label>
                        <input type="text" class="form-control" id="contraseña" name="contraseña" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                <form action="{{route('Mostrar')}}" onsubmit="showLoading()" method="get">
                    @csrf
                    <button type="submit" class="btn btn-link">Equipos</button>
                </form>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <form action="{{ route('principal') }}" onsubmit="showLoading()" method="get">
            @csrf
            <button type="submit" class="btn btn-secondary">Inicio</button>
        </form>
    </div>
    @endsection

    