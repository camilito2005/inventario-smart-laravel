<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use Illuminate\Support\Facades\DB;
use App\Models\Dispositivos;
use FPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class DispositivosController extends Controller
{
    public function Formulario(){
        $categorias = Categoria::all();

        return view('dispositivos/formularioD', compact('categorias'));
    }
    public function editar($id)
    {
        $dispositivo = Dispositivos::findOrFail($id); // Obtener el dispositivo por ID
        $categorias = Categoria::all(); // Obtener todas las categorías

        return view('dispositivos/EditD', compact('dispositivo', 'categorias','id'));
    }

    public function Ingresar(Request $request)
    {
        $validated = $request->validate([
            'dispositivo_marca' => 'required|string|max:255',
            'dispositivo_modelo' => 'required|string|max:255',
            'dispositivo_ram' => 'required|string|max:255',
            'dispositivo_procesador' => 'required|string|max:255',
            'dispositivo_almacenamiento' => 'required|string|max:255',
            'dispositivo_perifericos' => 'required|string|max:255',
            'dispositivo_nombre' => 'required|string|max:255',
            'dispositivo_direccion_mac' => 'required|string|max:255',
            'observacion' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,categoria_id',
            'dispositivo_contraseña' => 'required|string|max:255',
        ]);

        $query = DB::table('dispositivos')
            ->insert([
                'dispositivo_marca' => $validated['dispositivo_marca'],
                'dispositivo_modelo' => $validated['dispositivo_modelo'],
                'dispositivo_ram' => $validated['dispositivo_ram'],
                'dispositivo_procesador' => $validated['dispositivo_procesador'],
                'dispositivo_almacenamiento' => $validated['dispositivo_almacenamiento'],
                'dispositivo_perifericos' => $validated['dispositivo_perifericos'],
                'dispositivo_nombre_usuario' => $validated['dispositivo_nombre'],
                'fecha_registro' => now(),
                'dispositivo_direccion_mac' => $validated['dispositivo_direccion_mac'],
                'observacion' => $validated['observacion'],
                'categoria_id' => $validated['categoria_id'],
                'dispositivo_contraseña' => $validated['dispositivo_contraseña'],
            ]);

        if ($query) {
            return redirect()->route('Mostrar.dispositivos')->with('success', 'Equipo registrado exitosamente.');
        } else {
            return redirect()->route('Formulario.dispositivos')->with('error', 'Ocurrió un error al registrar el equipo.');
        }
    }

    public function MostrarEquipos(Request $request)
    {
        if (!session('nombre')) {
            return redirect()->route('Login_html')->with('mensaje', 'Inicia sesión para continuar.');
        }
        $mensaje = $request->query('mensaje', '');
        $filtroCategorias = $request->query('categoria');
        $registrosPorPagina = 10;

        // Obtener categorías
        $categorias = DB::table('categorias')->select('categoria_id', 'nombre')->get();

        // Consulta base para equipos
        $query = DB::table('dispositivos')
            ->join('categorias', 'dispositivos.categoria_id', '=', 'categorias.categoria_id')
            ->select(
                'dispositivos.dispositivo_id as id',
                'dispositivos.dispositivo_nombre_usuario as nombre',
                'dispositivos.dispositivo_marca as marca',
                'dispositivos.dispositivo_modelo as modelo',
                'dispositivos.dispositivo_ram as ram',
                'dispositivos.dispositivo_procesador as procesador',
                'dispositivos.dispositivo_almacenamiento as almacenamiento',
                'dispositivos.dispositivo_direccion_mac as dir_mac',
                'dispositivos.dispositivo_perifericos as perifericos',
                'dispositivos.observacion',
                'dispositivos.dispositivo_contraseña as contraseña',
                'categorias.nombre as categoria_descripcion'
            )->orderBy('dispositivos.dispositivo_id', 'asc');

        if ($filtroCategorias) {
            $query->where('dispositivos.categoria_id', '=', $filtroCategorias);
        }

        // Paginación
        // $equipos = $query->paginate($registrosPorPagina);
        $equipos = $query->paginate($registrosPorPagina)->appends(['categoria' => $filtroCategorias]);


        return view('dispositivos/MostrarE', compact('mensaje', 'categorias', 'equipos', 'filtroCategorias'));
    }
    public function update(Request $request, $id)
{
   // Valida los datos del formulario
    $request->validate([
        'marca' => 'required|string|max:255',
        'modelo' => 'required|string|max:255',
        'ram' => 'nullable|string|max:255',
        'procesador' => 'nullable|string|max:255',
        'almacenamiento' => 'nullable|string|max:255',
        'perifericos' => 'nullable|string|max:255',   
        'nombre' => 'required|string|max:255',
        'dir_mac' => 'nullable|string|max:255',
        'observacion' => 'nullable|string',
        'categoria' => 'required|integer',
    ]);

    // Actualiza el dispositivo en la base de datos
    $consulta = DB::table('dispositivos')
        ->where('dispositivo_id', $id)
        ->update([
            'dispositivo_marca' => $request->marca,
            'dispositivo_modelo' => $request->modelo,
            'dispositivo_ram' => $request->ram,
            'dispositivo_procesador' => $request->procesador,
            'dispositivo_almacenamiento' => $request->almacenamiento,
            'dispositivo_perifericos' => $request->perifericos,
            'dispositivo_nombre_usuario' => $request->nombre,
            'dispositivo_direccion_mac' => $request->dir_mac,
            'observacion' => $request->observacion,
            'categoria_id' => $request->categoria,
            'dispositivo_contraseña' => $request->contraseña,

        ]);
        if ($consulta) {
            return redirect()->route('Mostrar.dispositivos')->with(['mensaje'=> 'Dispositivo actualizado correctamente']);
        }
        else {
            return redirect()->route('Mostrar.dispositivos')->with(['mensaje'=>'error']);
        }
}
public function Eliminar($id)
{
    try {
        // Decodifica el ID si está codificado en base64
        // $id = base64_decode($id);

        // Ejecuta la consulta de eliminación
        $deleted = DB::table('dispositivos')->where('dispositivo_id', $id)->delete();

        // Redirecciona dependiendo del resultado
        if ($deleted) {
            return redirect()->route('Mostrar.dispositivos')->with(['mensaje'=> "El registro con ID $id fue eliminado correctamente."]);
        } else {
            return redirect()->route('Mostrar.dispositivos')->with(['mensaje'=> "Ocurrió un error al intentar eliminar el registro con ID $id."]);
        }
    } catch (\Exception $e) {
        // Manejo de excepciones
        return redirect()->route('Mostrar.dispositivos')->with(['mensaje'=> "Error: " . $e->getMessage()]);
    }
}
    public function generarPDF(){
    // Obtiene los dispositivos de la base de datos
    $equipos = DB::table('dispositivos')
        ->select('dispositivo_nombre_usuario', 'dispositivo_marca', 'dispositivo_modelo', 'dispositivo_ram', 'dispositivo_procesador')
        ->orderBy('dispositivo_id')
        ->get();

    // Crea una instancia de FPDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    // Encabezado del PDF
    $pdf->Cell(0, 10, 'Reporte de Equipos - Inventario SmartInfo', 0, 1, 'C');
    $pdf->Ln(5); // Salto de línea

    // Encabezado de la tabla
    $pdf->SetFillColor(200, 200, 200); // Color gris claro
    $pdf->Cell(30, 10, 'Nombre', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Marca', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Modelo', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'RAM', 1, 0, 'C', true);
    $pdf->Cell(35, 10, 'Procesador', 1, 1, 'C', true);

    // Datos de la tabla
    $pdf->SetFont('Arial', '', 10);

    if ($equipos->isNotEmpty()) {
        foreach ($equipos as $equipo) {
            $pdf->Cell(30, 10, utf8_decode($equipo->dispositivo_nombre_usuario), 1, 0, 'C');
            $pdf->Cell(30, 10, utf8_decode($equipo->dispositivo_marca), 1, 0, 'C');
            $pdf->Cell(40, 10, utf8_decode($equipo->dispositivo_modelo), 1, 0, 'C');
            $pdf->Cell(30, 10, $equipo->dispositivo_ram, 1, 0, 'C');
            $pdf->Cell(35, 10, utf8_decode($equipo->dispositivo_procesador), 1, 1, 'C');
        }
    } else {
        $pdf->Cell(165, 10, 'No hay equipos registrados.', 1, 1, 'C');
    }

    // Salida del PDF
    $pdf->Output('D', 'reporte_equipos.pdf'); // Descarga el archivo
    exit; // Detiene la ejecución después de generar el PDF
}
public function generarExcel()
    {
        // Consulta a la base de datos
        $equipos = DB::table('dispositivos')
            ->join('categorias', 'dispositivos.categoria_id', '=', 'categorias.categoria_id')
            ->select(
                'dispositivos.dispositivo_nombre_usuario as nombre',
                'dispositivos.dispositivo_marca as marca',
                'dispositivos.dispositivo_modelo as modelo',
                'dispositivos.dispositivo_ram as ram',
                'dispositivos.dispositivo_procesador as procesador',
                'dispositivos.dispositivo_almacenamiento as almacenamiento',
                'dispositivos.dispositivo_direccion_mac as dir_mac',
                'dispositivos.dispositivo_perifericos as perifericos',
                'dispositivos.observacion as observacion',
                'dispositivos.dispositivo_contraseña as contraseña',
                'categorias.nombre as categoria_descripcion'
            )
            ->orderBy('dispositivos.dispositivo_id')
            ->get();

        // Crear un nuevo archivo Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados
        $encabezados = [
            'Nombre', 'Marca', 'Modelo', 'Memoria RAM', 'Procesador',
            'Almacenamiento', 'Dirección MAC', 'Periféricos', 'Observación',
            'Contraseña', 'Categoría'
        ];
        $sheet->fromArray($encabezados, NULL, 'A1');

        // Insertar datos
        $fila = 2;
        foreach ($equipos as $equipo) {
            $datos = [
                $equipo->nombre,
                $equipo->marca,
                $equipo->modelo,
                $equipo->ram,
                $equipo->procesador,
                $equipo->almacenamiento,
                $equipo->dir_mac,
                $equipo->perifericos,
                $equipo->observacion,
                $equipo->contraseña,
                $equipo->categoria_descripcion
            ];
            $sheet->fromArray($datos, NULL, "A{$fila}");
            $fila++;
        }

        // Configurar la descarga del archivo Excel
        $writer = new Xlsx($spreadsheet);
        $filename = 'equipos.xlsx';

        // Encabezados HTTP para la descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }
    public function buscar(Request $request){
        $search = $request->input('search');

        if ($search) {
            // Consulta a la base de datos usando DB::table y LIKE
            $equipos = DB::table('dispositivos')
                ->join('categorias', 'dispositivos.categoria_id', '=', 'categorias.categoria_id')
                ->select(
                    'dispositivos.dispositivo_id as id',
                    'dispositivos.dispositivo_marca as marca',
                    'dispositivos.dispositivo_modelo as modelo',
                    'dispositivos.dispositivo_ram as ram',
                    'dispositivos.dispositivo_procesador as procesador',
                    'dispositivos.dispositivo_almacenamiento as almacenamiento',
                    'dispositivos.dispositivo_perifericos as perifericos',
                    'dispositivos.dispositivo_nombre_usuario as nombre',
                    'dispositivos.dispositivo_direccion_mac as dir_mac',
                    'dispositivos.observacion as observaciones',
                    'dispositivos.dispositivo_contraseña as contraseña',
                    'categorias.nombre as categoria'
                )
                ->where('dispositivos.dispositivo_nombre_usuario', 'ILIKE', "%{$search}%")
                ->get();

            return response()->json($equipos);
        }

        return response()->json([]);
    }

}
