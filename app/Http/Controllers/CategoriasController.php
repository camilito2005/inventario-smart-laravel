<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CategoriasController extends Controller
{
    public function MostrarCategorias()
    {
        if (!session()->has('nombre')) {
            return redirect()->route('Login_html')->with('mensaje', 'Inicia sesión para continuar');
        }

        $user = Auth::user();
        
        $categorias = DB::table('categorias')->orderBy('categoria_id')->get();

        $usuarioActual = session('nombre');

        return view('categorias.mostrarcategorias', compact('usuarioActual','categorias','user'));
    }
    public function formularioCategorias()
    {
        if (!session()->has('nombre')) {
            return redirect()->route('Login_html')->with('mensaje', 'Inicia sesión para continuar');
        }

        $usuarioActual = session('nombre');

        return view('categorias/formulario', compact('usuarioActual'));
    }

    public function FormularioEdit($id)
    {
        

        // Validar que el ID sea numérico
        if (!is_numeric($id)) {
            return redirect()->route('categories.mostrarcategorias')->withErrors('ID inválido.');
        }

        // Obtener la categoría por ID
        $category = DB::table('categorias')->where('categoria_id', $id)->first();

        if (!$category) {
            return redirect()->route('categories.mostrarcategorias')->withErrors('Categoría no encontrada.');
        }

        // Pasar los datos a la vista
        return view('categorias.Formularioeditar', ['category' => $category, 'id' => $id]);
    }

    public function ingresarCategorias(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $nombre = $request->input('nombre');

        DB::table('categorias')->insert([
            'nombre' => $nombre,
        ]);

        return redirect()->route('Categorias')->with('mensaje', 'Categoría registrada correctamente.');
    }
    public function updateCategory(Request $request, $id)
    {
        // Validar que el ID sea válido
        if (!is_numeric($id)) {
            return redirect()->route('categorias/mostrarcategorias')->withErrors('ID inválido.');
        }

        // Validar los datos del formulario
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        // Obtener los datos validados
        $nombre = $validatedData['nombre'];

        // Actualizar la categoría en la base de datos
        $updated = DB::table('categorias')
            ->where('categoria_id', $id)
            ->update([
                'nombre' => $nombre,
            ]);

        if ($updated) {
            // Redirigir al listado de categorías con un mensaje de éxito
            return redirect()->route('Categorias')->with('success', 'Categoría actualizada correctamente.');
        } else {
            // Manejar errores de actualización
            return redirect()->route('Categorias')->withErrors('Error al actualizar la categoría.');
        }
    }

    public function Eliminar($id)
    {
        // Validar que el ID sea numérico
        if (!is_numeric($id)) {
            return redirect()->route('Categorias')->withErrors('ID inválido.');
        }

        try {
            // Eliminar la categoría
            $deleted = DB::table('categorias')->where('categoria_id', $id)->delete();

            if ($deleted) {
                return redirect()->route('Categorias')->with('success', "Categoría con ID $id eliminada correctamente.");
            } else {
                return redirect()->route('Categorias')->withErrors("No se pudo eliminar la categoría con ID $id.");
            }
        } catch (\Exception $e) {
            // Manejar errores
            return redirect()->route('Categorias')->withErrors('Ocurrió un error: ' . $e->getMessage());
        }
    }
}
