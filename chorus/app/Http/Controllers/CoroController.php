<?php

namespace App\Http\Controllers;

use App\Models\Coro;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;

class CoroController extends Controller
{
    // Mostrar la lista de coros
    public function mostrarCoros()
    {
        $coros = Coro::all();
        return JsonResource::collection($coros);
    }

    // Mostrar el formulario de creación de coro
    public function verCrearCoro()
    {
        return view('coros.crear');
    }

    // Almacenar un nuevo coro en la base de datos
    public function crearCoro(Request $request)
    {
        $reglas = [
            'nombre' => 'required|string',
            'ciudad' => 'required|string',
            'direccion' => 'required|string',
            'tipo' => 'required|string',
            'estilo' => 'required|string'
        ];

        $mensajes = [
            'nombre.required' => 'El nombre es obligatorio.',
            'ciudad.required' => 'La ciudad son obligatoria.',
            'direccion.required' => 'La dirección es obligatoria.',
            'tipo.required' => 'El tipo es obligatorio.',
            'estilo.required' => 'El estilo es obligatorio',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return redirect()
                ->back()
                ->withErrors($validaciones)
                ->withInput();
        }

        coro::create($request->all());

        return redirect()->route('coros.mostrar')
            ->with('success', 'coro creado');
    }

    // Mostrar el detalle de un coro
    public function verCoro(Request $request)
    {
        $coro = Coro::find($request->id);
        return view('coros.coro', @compact('coro'));
    }

    // Mostrar el formulario de edición de un coro
    public function verEditarCoro(Request $request)
    {
        $coro = Coro::find($request->id);
        return view('coros.editar', @compact('coro'));
    }

    // Actualizar la información de un coro en la base de datos
    public function editarCoro(Request $request)
    {
        $reglas = [
            'nombre' => 'required|string',
            'ciudad' => 'required|string',
            'direccion' => 'required|string',
            'tipo' => 'required|string',
            'estilo' => 'required|string'
        ];

        $mensajes = [
            'nombre.required' => 'El nombre es obligatorio.',
            'ciudad.required' => 'La ciudad son obligatoria.',
            'direccion.required' => 'La dirección es obligatoria.',
            'tipo.required' => 'El tipo es obligatorio.',
            'estilo.required' => 'El estilo es obligatorio',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return redirect()
                ->back()
                ->withErrors($validaciones)
                ->withInput();
        }

        $coro = Coro::find($request->id);
        $coro->update($request->all());

        return redirect()->route('coros.mostrar')
            ->with('success', 'coro actualizado');
    }

    // Eliminar un coro de la base de datos
    public function eliminarCoro(Request $request)
    {
        $coro = Coro::find($request->id);
        $coro->delete();

        return redirect()->route('coros.mostrar')
            ->with('success', 'coro eliminado');
    }
}