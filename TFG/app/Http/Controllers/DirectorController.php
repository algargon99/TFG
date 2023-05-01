<?php

namespace App\Http\Controllers;

use App\Models\Director;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DirectorController extends Controller
{
    // Mostrar la lista de directores
    public function mostrarDirectores()
    {
        $directores = Director::all();
        return view('directores.mostrar', @compact('directores'));
    }

    // Mostrar el formulario de creación de director
    public function verCrearDirector()
    {
        return view('directores.crear');
    }

    // Almacenar un nuevo director en la base de datos
    public function crearDirector(Request $request)
    {
        $reglas = [
            'escuela' => 'required|string',
        ];

        $mensajes = [
            'escuela.required' => 'La escuela es obligatoria.',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return redirect()
                ->back()
                ->withErrors($validaciones)
                ->withInput();
        }

        director::create($request->all());

        return redirect()->route('directores.mostrar')
            ->with('success', 'director creado');
    }

    // Mostrar el detalle de un director
    public function verDirector(Request $request)
    {
        $director = Director::find($request->id);
        return view('directores.director', @compact('director'));
    }

    // Mostrar el formulario de edición de un director
    public function verEditarDirector(Request $request)
    {
        $director = Director::find($request->id);
        return view('directores.editar', @compact('director'));
    }

    // Actualizar la información de un director en la base de datos
    public function editarDirector(Request $request)
    {
        $reglas = [
            'escuela' => 'required|string',
        ];

        $mensajes = [
            'escuela.required' => 'La escuela es obligatoria.',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return redirect()
                ->back()
                ->withErrors($validaciones)
                ->withInput();
        }

        $director = Director::find($request->id);
        $director->update($request->all());

        return redirect()->route('directores.mostrar')
            ->with('success', 'director actualizado');
    }

    // Eliminar un director de la base de datos
    public function eliminarDirector(Request $request)
    {
        $director = Director::find($request->id);
        $director->delete();

        return redirect()->route('directores.mostrar')
            ->with('success', 'director eliminado');
    }
}