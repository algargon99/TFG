<?php

namespace App\Http\Controllers;

use App\Models\Coro;
use App\Models\RelUsuarioCoro;
use App\Models\Usuario;
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

    // Mostrar los coros de un usuario
    public function corosUsuario($id)
    {
        // Obtén el usuario por su ID junto con los coros relacionados
        $usuarioConCoros = Usuario::with('relUsuarioCoro.coro')->find($id);


        if ($usuarioConCoros->admin == 1) {
            return Coro::all();
        }

        $corosDelUsuario = $usuarioConCoros->relUsuarioCoro->map(function ($relUsuarioCoro) {
            return $relUsuarioCoro->coro;
        });

        return $corosDelUsuario;
    }

    // Almacenar un nuevo coro en la base de datos
    public function store(Request $request)
    {

        $reglas = [
            'nombre' => 'required|string',
            'ciudad' => 'required|string',
            'direccion' => 'required|string',
            'tipo' => 'required|string',
            'estilo' => 'required|string',
            'descripcion' => 'required|string',
            'archivo' => 'required'
        ];

        $mensajes = [
            'nombre.required' => 'El nombre es obligatorio.',
            'ciudad.required' => 'La ciudad son obligatoria.',
            'direccion.required' => 'La dirección es obligatoria.',
            'tipo.required' => 'El tipo es obligatorio.',
            'estilo.required' => 'El estilo es obligatorio',
            'descripcion.required' => 'La descripción es obligatoria',
            'archivo' => 'La foto es obligatoria',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return $validaciones->errors()->all();
        }

        try {
            DB::beginTransaction();
            $coro = new Coro();
            $coro->nombre = $request->nombre;
            $coro->ciudad = $request->ciudad;
            $coro->direccion = $request->direccion;
            $coro->tipo = $request->tipo;
            $coro->estilo = $request->estilo;
            $coro->descripcion = $request->descripcion;
            if ($request->hasFile('archivo')) {
                $archivo = $request->file('archivo');
                $archivo->move(public_path('img/coro'), 'coro' . time() . '.png');
                $coro->archivo = 'img/coro/' . 'coro' . time() . '.png';
            }
            $res = $coro->save();
            DB::commit();
            return $res;
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
            'estilo' => 'required|string',
            'descripcion' => 'required|string'
        ];

        $mensajes = [
            'nombre.required' => 'El nombre es obligatorio.',
            'ciudad.required' => 'La ciudad son obligatoria.',
            'direccion.required' => 'La dirección es obligatoria.',
            'tipo.required' => 'El tipo es obligatorio.',
            'estilo.required' => 'El estilo es obligatorio',
            'descripcion.required' => 'La descripción es obligatoria',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return $validaciones->errors()->all();
        }

        DB::beginTransaction();

        try {
            $coro = Coro::find($id);
            $coro->nombre = $request->nombre;
            $coro->ciudad = $request->ciudad;
            $coro->direccion = $request->direccion;
            $coro->tipo = $request->tipo;
            $coro->estilo = $request->estilo;
            $coro->descripcion = $request->descripcion;
            $res = $coro->save();

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
        if (isset($coro)) {
            $partituras = $coro->partituras->count();

            if ($partituras > 0) {
                return ['Hay ' . $partituras . ' partituras asociadas', ''];
            }
            $res = Coro::destroy($id);
            if ($res) {
                return 1;
            } else {
                return response()->json([
                    'data' => $coro,
                    'mensaje' => 'Coro no borrado'
                ]);
            }
        } else {
            return response()->json([
                'data' => $coro,
                'mensaje' => 'Coro no existe'
            ]);
        }
    }

    public function cantoresCoro($id)
    {
        $coro = Coro::find($id);

        $usuariosDelCoro = $coro->relUsuarioCoros->map(function ($usuarioCoro) {
            return $usuarioCoro->usuario;
        });

        $cantoresDelCoro = $usuariosDelCoro->filter(function ($usuario) {
            return $usuario->cantor !== null;
        })->values();

        return $cantoresDelCoro;
    }

    public function directoresCoro($id)
    {
        $coro = Coro::find($id);

        $usuariosDelCoro = $coro->relUsuarioCoros->map(function ($usuarioCoro) {
            return $usuarioCoro->usuario;
        });

        $directoresDelCoro = $usuariosDelCoro->filter(function ($usuario) {
            return $usuario->director !== null;
        })->values();

        return $directoresDelCoro;
    }
}
