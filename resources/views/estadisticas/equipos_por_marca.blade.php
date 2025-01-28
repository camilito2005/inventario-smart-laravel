@extends('layouts.app')
@section('content')
    @push('estilos')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush

    <div class="container mt-5">
        <h2 class="text-center mb-4">Cantidad de Equipos por Marca</h2>
        <canvas id="chartEquipos"></canvas>

        <script>
            'marcas' => json_encode($marcas),
'totales' => json_encode($totales),

            const ctx = document.getElementById('chartEquipos').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! $marcas !!},
                    datasets: [{
                        label: 'Cantidad de Equipos',
                        data: {!! $totales !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },

                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        </script>

        <div class="d-flex justify-content-center mt-4">
            <form action="{{route('estadisticas.excel')}}" method="post" class="mx-2">
                @csrf
                <button class="btn btn-success" type="submit">
                    <i class="fas fa-file-excel"></i> Exportar a Excel
                </button>
            </form>

            <form action="{{route('estadisticas.pdf')}}" method="post" class="mx-2">
                @csrf
                <button class="btn btn-danger" type="submit">
                    <i class="fas fa-file-pdf"></i> Exportar a PDF
                </button>
            </form>

            <a href="{{ route('principal') }}" class="btn btn-secondary mx-2">
                <i class="fas fa-home"></i> Inicio
            </a>
        </div>
    </div>
@endsection
