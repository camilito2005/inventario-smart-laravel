<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas de Productos Más Vendidos</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Top Productos Más Vendidos</h2>
        <canvas id="chartProductos"></canvas>
        <script>
            // Datos para el gráfico
            const productos = {!! json_encode($productos) !!};
            const totales = {!! json_encode($totales) !!};

            const ctx = document.getElementById('chartProductos').getContext('2d');
            new Chart(ctx, {
                type: 'bar', // Tipo de gráfico
                data: {
                    labels: productos,
                    datasets: [{
                        label: 'Total Vendido',
                        data: totales,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
        <form id="myForm" action="{{ url('principal') }}" method="get">
            <button class="btn btn-outline-secondary mt-3" type="submit">
                <i class="fa-solid fa-house"></i> Inicio
            </button>
        </form>
    </div>
</body>
</html>
