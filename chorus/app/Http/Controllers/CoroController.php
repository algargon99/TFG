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
            return $validaciones->fails();
        }

        $inputs = $request->input();
        $respuesta = Coro::create($inputs);
        return $respuesta;
    }

    // Mostrar el detalle de un coro
    public function verCoro($id)
    {
        $coro = Coro::find($id);
        return $coro;
    }

    // Actualizar la información de un coro en la base de datos
    public function editarCoro(Request $request, $id)
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
            return $validaciones->fails();
        }

        $coro = Coro::find($id);
        $res = $coro->update($request->input());
        return $res;

    }

    // Eliminar un coro de la base de datos
    public function eliminarCoro($id)
    {
        $coro = Coro::find($id);
        if ($coro) {
            $coro->delete();
        }
    }
}
