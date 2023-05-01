<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AudioController extends Controller
{
    public function mostrarAudios()
    {
        $audio = Audio::all();
        return view('audio', compact('audio'));
    }

    public function verCrearAudio()
    {
        return view('verNewAudio');
    }

    public function crearAudio(Request $request)
    {

        $reglas = [
            'obra' => 'required|string|max:255',
            'duracion' => 'required|integer|min:1',
            'interprete' => 'required|string|max:255',
            'audio' => 'required|mimetypes:audio/*|max:2048',
        ];

        $mensajes = [
            'obra.required' => 'El nombre de la obra es obligatorio.',
            'duracion.required' => 'La duración es obligatoria.',
            'duracion.integer' => 'La duración ha de ser un número entero.',
            'duracion.min' => 'La duración tiene que ser mínimo de 1 minuto.',
            'interprete.required' => 'El interprete es obligatorio.',
            'audio.required' => 'El audio es obligatorio',
            'audio.mimetypes' => 'El tipo de archivo tiene que ser de audio',
            'audio.max' => 'El archivo puede pesar como máximo 2 MB',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        $audio = new Audio();

        if ($validaciones->fails()) {
            return redirect()
                ->back()
                ->withErrors($validaciones)
                ->withInput();
        }

        $audio = new Audio();
        $audio->obra = $request->obra;
        $audio->duracion = $request->duracion;
        $audio->interprete = $request->interprete;
        $naudio = 'audios/' . $_FILES['audio']['name'];
        move_uploaded_file($_FILES['audio']['tmp_name'], $naudio);
        $audio->audio = $naudio;
        $audio->idPartitura = $request->idPartitura;

        $audio->save();

        return redirect()->route('audio.index')->with('success', 'Audio creado correctamente');
    }

    public function show(Request $request)
    {
        return view('audio.show', compact('audio'));
    }

    public function edit(Request $request)
    {
        return view('audio.edit', compact('audio'));
    }

    public function update(Request $request)
    {
        $reglas = [
            'obra' => 'required|string|max:255',
            'duracion' => 'required|integer|min:1',
            'interprete' => 'required|string|max:255',
            'audio' => 'mimetypes:audio/*|max:2048',
        ];

        $mensajes = [
            'obra.required' => 'El nombre de la obra es obligatorio.',
            'duracion.required' => 'La duración es obligatoria.',
            'duracion.integer' => 'La duración ha de ser un número entero.',
            'duracion.min' => 'La duración tiene que ser mínimo de 1 minuto.',
            'interprete.required' => 'El interprete es obligatorio.',
            'audio.mimetypes' => 'El tipo de archivo tiene que ser de audio',
            'audio.max' => 'El archivo puede pesar como máximo 2 MB',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        $audio = Audio::find($request->id);

        if ($validaciones->fails()) {
            return redirect()
                ->back()
                ->withErrors($validaciones)
                ->withInput();
        }

        $audio->obra = $request->obra;
        $audio->duracion = $request->duracion;
        $audio->interprete = $request->interprete;
        $naudio = 'audios/' . $_FILES['audio']['name'];
        if ($naudio != "") {
            move_uploaded_file($_FILES['audio']['tmp_name'], $naudio);
            $audio->audio = $naudio;
        }
        $audio->idPartitura = $request->idPartitura;

        $audio->save();

        return redirect()->route('audio.index')->with('success', 'Audio actualizado correctamente');
    }

    public function destroy(Request $request)
    {
        $audio = Audio::find($request->id);
        $audio->delete();

        return redirect()->route('audio.index')->with('success', 'Audio eliminado correctamente');
    }
}
