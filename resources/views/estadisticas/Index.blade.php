@extends('layouts.app')
@section('content')
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
    <div class="container mt-5">
        <h1 class="text-center">Estadísticas del Inventario</h1>
        <div class="row mt-4">
            <!-- Gráfico: Productos por Categoría -->
            <div class="col-md-6">
                <h2>Productos por Categoría</h2>
                <canvas id="graficoCategorias"></canvas>
            </div>

            <!-- Gráfico: Usuarios por Rol -->
            <div class="col-md-6">
                <h2>Usuarios por Rol</h2>
                <canvas id="graficoUsuarios"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Datos desde el servidor
        const categorias = @json($categorias);
        const usuarios = @json($usuarios);

        // Gráfico de Productos por Categoría
        const ctxCategorias = document.getElementById('graficoCategorias').getContext('2d');
        new Chart(ctxCategorias, {
            type: 'bar',
            data: {
                labels: categorias.map(c => c.categoria),
                datasets: [{
                    label: 'Cantidad de productos',
                    data: categorias.map(c => c.cantidad),
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: true }
                }
            }
        });

        // Gráfico de Usuarios por Rol
        const ctxUsuarios = document.getElementById('graficoUsuarios').getContext('2d');
        new Chart(ctxUsuarios, {
            type: 'pie',
            data: {
                labels: usuarios.map(u => u.rol),
                datasets: [{
                    label: 'Cantidad de usuarios',
                    data: usuarios.map(u => u.cantidad),
                    backgroundColor: ['rgba(255, 99, 132, 0.6)', 'rgba(54, 162, 235, 0.6)', 'rgba(255, 206, 86, 0.6)'],
                    borderColor: 'rgba(255, 255, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: { enabled: true }
                }
            }
        });
    </script>
    <a href="{{ route('principal') }}" class="btn btn-secondary mx-2">
        <i class="fas fa-home"></i> Inicio
    </a>
@endsection
