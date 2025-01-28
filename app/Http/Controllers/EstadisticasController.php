<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use FPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class EstadisticasController extends Controller
{
    //

    public function index()
    {
        if (!session('nombre')) {
            return redirect()->route('Login_html')->with('mensaje', 'Inicia sesión para continuar.');
        }
        // Consulta para dispositivos por categoría
        $categorias = DB::select("
           SELECT 
                c.nombre AS categoria, 
                COUNT(d.dispositivo_id) AS cantidad
            FROM 
                categorias c
            LEFT JOIN 
                dispositivos d 
            ON 
                c.categoria_id = d.categoria_id
            GROUP BY 
                c.nombre
            ORDER BY 
    cantidad DESC;
        ");

        // Consulta para usuarios por rol
        $usuarios = DB::select("
            SELECT r.descripcion AS rol, COUNT(u.id) AS cantidad
            FROM usuarios u
            INNER JOIN roles r ON u.rol_id = r.id
            GROUP BY r.descripcion
        ");

        // Pasar los datos a la vista
        return view('estadisticas/Index', [
            'categorias' => $categorias,
            'usuarios' => $usuarios,
        ]);
    }
    
    public function equiposPorMarca()
    {
        // Verificar si el usuario está autenticado
        if (!session('nombre')) {
            return redirect()->route('Login_html')->with('mensaje', 'Inicia sesión para continuar.');
        }

        // Consulta para obtener los equipos agrupados por marca
        $equiposPorMarca = DB::table('dispositivos')
            ->select('dispositivo_marca', DB::raw('COUNT(*) as total_equipos'))
            ->groupBy('dispositivo_marca')
            ->orderByDesc('total_equipos')
            ->get();

        // Preparar datos para Chart.js
        $marcas = $equiposPorMarca->pluck('dispositivo_marca')->toArray();
        $totales = $equiposPorMarca->pluck('total_equipos')->toArray();

        return view('estadisticas.equipos_por_marca', [
            'marcas' => json_encode($marcas),
            'totales' => json_encode($totales),
        ]);
    }

    public function exportarEquiposPorMarca()
    {
        // Consulta SQL para obtener equipos agrupados por marca
        $equiposPorMarca = DB::select("
            SELECT 
                dispositivo_marca,
                COUNT(*) AS total_equipos
            FROM 
                dispositivos
            GROUP BY 
                dispositivo_marca
            ORDER BY 
                total_equipos DESC
        ");

        // Crear el archivo Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Equipos por Marca');

        // Encabezados
        $sheet->setCellValue('A1', 'Marca');
        $sheet->setCellValue('B1', 'Total Equipos');

        // Llenar los datos
        $fila = 2;
        foreach ($equiposPorMarca as $equipo) {
            $sheet->setCellValue("A$fila", $equipo->dispositivo_marca);
            $sheet->setCellValue("B$fila", $equipo->total_equipos);
            $fila++;
        }

        // Configurar encabezados para la descarga
        $nombreArchivo = 'Equipos_Por_Marca.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$nombreArchivo\"");

        // Descargar el archivo
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
    public function Pdf()
    {
        // Consulta SQL para obtener equipos agrupados por marca
        $equiposPorMarca = DB::select("
            SELECT 
                dispositivo_marca,
                COUNT(*) AS total_equipos
            FROM 
                dispositivos
            GROUP BY 
                dispositivo_marca
            ORDER BY 
                total_equipos DESC
        ");

        // Crear el PDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Equipos por Marca', 0, 1, 'C');

        // Encabezados
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(90, 10, 'Marca', 1);
        $pdf->Cell(90, 10, 'Total Equipos', 1, 1);

        // Llenar datos
        $pdf->SetFont('Arial', '', 10);
        foreach ($equiposPorMarca as $equipo) {
            $pdf->Cell(90, 10, $equipo->dispositivo_marca, 1);
            $pdf->Cell(90, 10, $equipo->total_equipos, 1, 1);
        }

        // Generar y enviar el archivo PDF
        $pdf->Output('D', 'Equipos_Por_Marca.pdf');
        exit();
    }
}
