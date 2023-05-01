<?php

namespace App\Http\Controllers;

use App\Models\Partitura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PartituraController extends Controller
{
    public function mostrarPartituras()
    {
        $partitura = Partitura::all();
        return view('partitura', compact('partitura'));
    }

    public function verCrearPartitura()
    {
        return view('verNewPartitura');
    }

    public function crearPartitura(Request $request)
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

        $partitura = new Partitura();

        if ($validaciones->fails()) {
            return redirect()
                ->back()
                ->withErrors($validaciones)
                ->withInput();
        }

        $partitura = new Partitura();
        $partitura->nombre = $request->nombre;
        $partitura->autor = $request->autor;
        $partitura->anio = $request->anio;
        $partitura->voces = $request->voces;
        $npartitura = 'partituras/' . $_FILES['partitura']['name'];
        move_uploaded_file($_FILES['partitura']['tmp_name'], $npartitura);
        $partitura->partitura = $npartitura;
        $partitura->idCoro = $request->idCoro;

        $partitura->save();

        return redirect()->route('partitura.index')->with('success', 'Partitura creado correctamente');
    }

    public function show(Request $request)
    {
        return view('partitura.show', compact('partitura'));
    }

    public function edit(Request $request)
    {
        return view('partitura.edit', compact('partitura'));
    }

    public function update(Request $request)
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

        $partitura = Partitura::find($request->id);

        if ($validaciones->fails()) {
            return redirect()
                ->back()
                ->withErrors($validaciones)
                ->withInput();
        }

        $partitura->obra = $request->obra;
        $partitura->duracion = $request->duracion;
        $partitura->interprete = $request->interprete;
        $npartitura = 'partituras/' . $_FILES['partitura']['name'];
        if ($npartitura != "") {
            move_uploaded_file($_FILES['partitura']['tmp_name'], $npartitura);
            $partitura->partitura = $npartitura;
        }
        $partitura->idPartitura = $request->idPartitura;

        $partitura->save();

        return redirect()->route('partitura.index')->with('success', 'Partitura actualizado correctamente');
    }

    public function destroy(Request $request)
    {
        $partitura = Partitura::find($request->id);
        $partitura->delete();

        return redirect()->route('partitura.index')->with('success', 'Partitura eliminado correctamente');
    }
}
