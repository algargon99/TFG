<?php

namespace App\Http\Controllers;

use App\Models\Coro;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CoroController extends Controller
{
    public function index()
    {
        return Coro::all();
    }

    public function corosUsuario($id)
    {
        $usuarioConCoros = Usuario::with('relUsuarioCoro.coro')->find($id);


        if ($usuarioConCoros->admin == 1) {
            return Coro::all();
        }

        $corosID = $usuarioConCoros->relUsuarioCoro->pluck('coro.id')->toArray();
        $corosUsuario = Coro::whereIn('id', $corosID)->get();
        $corosNoUsuario = Coro::whereNotIn('id', $corosID)->get();

        return response()->json([
            'corosUsuario' => $corosUsuario,
            'corosNoUsuario' => $corosNoUsuario
        ]);
    }

    public function store(Request $request)
    {

        $reglas = [
            'nombre' => 'required|string',
            'ciudad' => 'required|string',
            'direccion' => 'required|string',
            'tipo' => 'required|string',
            'estilo' => 'required|string',
            'descripcion' => 'required|string',
            'archivo' => 'required|mimes:png,jpg'
        ];

        $mensajes = [
            'nombre.required' => 'El nombre es obligatorio',
            'ciudad.required' => 'La ciudad es obligatoria',
            'direccion.required' => 'La dirección es obligatoria',
            'tipo.required' => 'El tipo es obligatorio',
            'estilo.required' => 'El estilo es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria',
            'archivo.required' => 'La foto es obligatoria',
            'archivo.mimes' => 'El archivo tiene que ser PNG o JPG',

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

    public function show($id)
    {
        return Coro::find($id);
    }

    public function update(Request $request, $id)
    {
        $reglas = [
            'nombre' => 'required|string',
            'ciudad' => 'required|string',
            'direccion' => 'required|string',
            'tipo' => 'required|string',
            'estilo' => 'required|string',
            'descripcion' => 'required|string',
            'archivo' => 'mimes:png,jpg',
            
        ];

        $mensajes = [
            'nombre.required' => 'El nombre es obligatorio',
            'ciudad.required' => 'La ciudad es obligatoria',
            'direccion.required' => 'La dirección es obligatoria',
            'tipo.required' => 'El tipo es obligatorio',
            'estilo.required' => 'El estilo es obligatorio',
            'descripcion.required' => 'La descripción es obligatoria',
            'archivo.mimes' => 'El archivo tiene que ser PNG o JPG',
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
            return response()->json(['error' => 'Error al actualizar el coro'], 500);
        }
    }

    public function destroy($id)
    {
        $coro = Coro::find($id);
        if (isset($coro)) {
            $partituras = $coro->partituras->count();

            if ($partituras > 0) {
                return ['Hay ' . $partituras . ' partituras asociadas', ''];
            }

            $rels = $coro->relUsuarioCoros->count();
            if ($rels > 0) {
                return ['Hay ' . $rels . ' usuarios asociados', ''];
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

    public function getVideo($id)
    {
        $coro = Coro::find($id);
        if ($coro) {
            $partituras = $coro->partituras;
            if (sizeof($partituras) > 0) {
                $videos = $partituras->random(1)->first()->videos;
                if (sizeof($videos)) {
                    $video = $videos->first();
                    return $video;
                } else {
                    return ['No hay vídeos',''];
                }
                
            } else {
                return ['No hay partituras',''];
            }
            
        } else {
            return ['No existe el coro',''];
        }

    }
}
