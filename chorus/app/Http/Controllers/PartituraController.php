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

        return $request;

        $reglas = [
            'nombre' => 'required|string',
            'autor' => 'required|string',
            'anio' => 'required|integer|min:0',
            'voces' => 'required|integer|min:1',
        ];

        $mensajes = [
            'nombre.required' => 'El nombre de la partitura es obligatorio.',
            'autor.required' => 'El autor es obligatorio.',
            'anio.required' => 'El año es obligatorio.',
            'anio.integer' => 'El año ha de ser un número entero.',
            'anio.min' => 'Tiene que ser por lo menos el año 0.',
            'voces.required' => 'Las voces son obligatorias.',
            'voces.integer' => 'Las voces tiene que ser un número entero.',
            'voces.min' => 'Tiene que haber al menos una voz.',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        $partitura = new Partitura();

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
            
            if ($request->hasFile('partitura')) {
                $archivo = $request->file('partitura');
                $nombreArchivo = $archivo->getClientOriginalName();
                $nuevoArchivo = $nombreArchivo.'.pdf';
                $rutaDestino = 'localhost:8080/public/pdf';
    
                $archivo->storeAs($rutaDestino, $nuevoArchivo);
                $partitura->archivo = "pdf/".$nombreArchivo;
            } else {
                
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
            'anio' => 'required|integer|min:0',
            'voces' => 'required|integer|min:1',
            'partitura' => 'required|mimes:PDF|max:2048',
        ];

        $mensajes = [
            'nombre.required' => 'El nombre de la partitura es obligatorio.',
            'autor.required' => 'El autor es obligatorio.',
            'anio.required' => 'El año es obligatorio.',
            'anio.integer' => 'El año ha de ser un número entero.',
            'anio.min' => 'Tiene que ser por lo menos el año 0.',
            'voces.required' => 'Las voces son obligatorias.',
            'voces.integer' => 'Las voces tiene que ser un número entero.',
            'voces.min' => 'Tiene que haber al menos una voz.',
            'partitura.required' => 'El partitura es obligatoria',
            'partitura.mimes' => 'El tipo de archivo tiene que ser de PDF',
            'partitura.max' => 'El archivo puede pesar como máximo 2 MB',
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
            $npartitura = 'partituras/' . $_FILES['partitura']['name'];
            move_uploaded_file($_FILES['partitura']['tmp_name'], $npartitura);
            $partitura->partitura = $npartitura;
            $res = $partitura->save();

            DB::commit();
            return $res;

        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    // Eliminar una partitura de la base de datos
    public function destroy($id)
    {
        $partitura = Partitura::find($id);
        if ($partitura) {
            $partitura->delete();
        }
    }
}
