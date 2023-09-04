<?php

namespace App\Http\Controllers;

use App\Models\Coro;
use App\Models\Partitura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class PartituraController extends Controller
{
    public function index($id)
    {
        $coro = Coro::find($id);
        return $coro->partituras;
    }


    public function store(Request $request, $id)
    {

        $reglas = [
            'nombre' => 'required|string',
            'autor' => 'required|string',
            'anio' => 'required|integer|min:0|max:2023',
            'voces' => 'required|integer|min:1',
            'archivo' => 'required|mimes:pdf',
        ];

        $mensajes = [
            'nombre.required' => 'El nombre de la partitura es obligatorio',
            'autor.required' => 'El autor es obligatorio',
            'anio.required' => 'El año es obligatorio',
            'anio.integer' => 'El año ha de ser un número entero',
            'anio.min' => 'Tiene que ser por lo menos el año 0',
            'anio.max' => 'El año de la partitura tiene que ser como mucho el año 2023',
            'voces.required' => 'Las voces son obligatorias',
            'voces.integer' => 'Las voces tiene que ser un número entero',
            'voces.min' => 'Tiene que haber al menos una voz',
            'archivo.required' => 'El archivo es obligatorio',
            'archivo.mimes' => 'El archivo tiene que ser PDF',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);


        if ($validaciones->fails()) {
            return $validaciones->errors()->all();
        }

        try {
            DB::beginTransaction();

            $partitura = new Partitura();
            $partitura->nombre = $request->nombre;
            $partitura->autor = $request->autor;
            $partitura->anio = $request->anio;
            $partitura->voces = $request->voces;

            if ($request->hasFile('archivo')) {
                $archivo = $request->file('archivo');
                $archivo->move(public_path('pdf'), 'partitura' . time() . '.pdf');
                $partitura->archivo = 'pdf/' . 'partitura' . time() . '.pdf';
            }

            $partitura->idCoro = $id;

            $res = $partitura->save();

            DB::commit();

            return $res;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function show($id)
    {
        return Partitura::find($id);
    }

    public function update(Request $request, $id)
    {

        $reglas = [
            'nombre' => 'required|string',
            'autor' => 'required|string',
            'anio' => 'required|integer|min:0|max:2023',
            'voces' => 'required|integer|min:1',
            'archivo' => 'mimes:pdf',
        ];

        $mensajes = [
            'nombre.required' => 'El nombre de la partitura es obligatorio',
            'autor.required' => 'El autor es obligatorio',
            'anio.required' => 'El año es obligatorio',
            'anio.integer' => 'El año ha de ser un número entero',
            'anio.min' => 'Tiene que ser por lo menos el año 0.',
            'anio.max' => 'El año de la partitura tiene que ser como mucho el año 2023',
            'voces.required' => 'Las voces son obligatorias',
            'voces.integer' => 'Las voces tiene que ser un número entero',
            'voces.min' => 'Tiene que haber al menos una voz',
            'archivo.mimes' => 'El archivo tiene que ser PDF',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return $validaciones->errors()->all();
        }

        try {
            DB::beginTransaction();

            $partitura = Partitura::find($id);
            $partitura->nombre = $request->nombre;
            $partitura->autor = $request->autor;
            $partitura->anio = $request->anio;
            $partitura->voces = $request->voces;

            if ($request->hasFile('archivo')) {
                $archivo = $request->file('archivo');
                $archivo->move(public_path('pdf'), 'partitura' . time() . '.pdf');
                $partitura->archivo = 'pdf/' . 'partitura' . time() . '.pdf';
            }
            $res = $partitura->save();

            DB::commit();
            return $res;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {
        $partitura = Partitura::find($id);
        if (isset($partitura)) {
            $videos = $partitura->videos->count();
            $audios = $partitura->audios->count();

            if ($audios > 0 || $videos > 0) {
                return ['Hay ' . $audios . ' audios asociados', 'Hay ' . $videos . ' vídeos asociados'];
            }

            $res = Partitura::destroy($id);
            if ($res) {
                return 1;
            } else {
                return response()->json([
                    'data' => $partitura,
                    'mensaje' => 'Partitura no borrada'
                ]);
            }
        } else {
            return response()->json([
                'data' => $partitura,
                'mensaje' => 'Partitura no existe'
            ]);
        }
    }
}
