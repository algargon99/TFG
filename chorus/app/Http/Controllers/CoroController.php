<?php

namespace App\Http\Controllers;

use App\Models\Coro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CoroController extends Controller
{
    // Mostrar la lista de coros
    public function index()
    {
        return Coro::all();
    }

    // Almacenar un nuevo coro en la base de datos
    public function store(Request $request)
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
            return $validaciones->errors()->all();
        }

        DB::beginTransaction();

        try {
            $inputs = $request->input();
            $respuesta = Coro::create($inputs);

            DB::commit();

            return $respuesta;
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Error al almacenar el coro'], 500);
        }
    }

    // Mostrar el detalle de un coro
    public function show($id)
    {
        return Coro::find($id);
        
    }

    // Actualizar la información de un coro en la base de datos
    public function update(Request $request, $id)
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
            return $validaciones->errors()->all();
        }

        DB::beginTransaction();

        try {
            $coro = Coro::find($id);
            $res = $coro->update($request->input());

            DB::commit();

            return $res;
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Error al actualizar el coro'], 500);
        }

    }

    // Eliminar un coro de la base de datos
    public function destroy($id)
    {
        $coro = Coro::find($id);
        if ($coro) {
            $coro->delete();
        }
    }
}
