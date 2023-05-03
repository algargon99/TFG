<?php

namespace App\Http\Controllers;

use App\Models\Cantor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CantorController extends Controller
{
    // Mostrar la lista de cantores
    public function mostrarCantores()
    {
        $cantores = Cantor::all();
        return view('cantores.mostrar', @compact('cantores'));
    }

    // Mostrar el formulario de creación de cantor
    public function verCrearCantor()
    {
        return view('cantores.crear');
    }

    // Almacenar un nuevo cantor en la base de datos
    public function crearCantor(Request $request)
    {
        $reglas = [
            'voz' => 'required|string',
        ];

        $mensajes = [
            'voz.required' => 'La voz es obligatoria.',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return redirect()
                ->back()
                ->withErrors($validaciones)
                ->withInput();
        }

        cantor::create($request->all());

        return redirect()->route('cantores.mostrar')
            ->with('success', 'cantor creado');
    }

    // Mostrar el detalle de un cantor
    public function verCantor(Request $request)
    {
        $cantor = Cantor::find($request->id);
        return view('cantores.cantor', @compact('cantor'));
    }

    // Mostrar el formulario de edición de un cantor
    public function verEditarCantor(Request $request)
    {
        $cantor = Cantor::find($request->id);
        return view('cantores.editar', @compact('cantor'));
    }

    // Actualizar la información de un cantor en la base de datos
    public function editarCantor(Request $request)
    {
        $reglas = [
            'voz' => 'required|string',
        ];

        $mensajes = [
            'voz.required' => 'La voz es obligatoria.',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return redirect()
                ->back()
                ->withErrors($validaciones)
                ->withInput();
        }

        $cantor = Cantor::find($request->id);
        $cantor->update($request->all());

        return redirect()->route('cantores.mostrar')
            ->with('success', 'cantor actualizado');
    }

    // Eliminar un cantor de la base de datos
    public function eliminarCantor(Request $request)
    {
        $cantor = Cantor::find($request->id);
        $cantor->delete();

        return redirect()->route('cantores.mostrar')
            ->with('success', 'cantor eliminado');
    }
}