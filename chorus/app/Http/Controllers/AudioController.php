<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use App\Models\Partitura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AudioController extends Controller
{
    public function index($id)
    {
        $partitura = Partitura::find($id);
        return $partitura->audios;
    }

    public function store(Request $request)
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

        if ($validaciones->fails()) {
            return $validaciones->errors()->all();
        }
        
        try {
            DB::beginTransaction();
            $audio = new Audio();
            $audio->obra = $request->obra;
            $audio->duracion = $request->duracion;
            $audio->interprete = $request->interprete;
            $naudio = 'audios/' . $_FILES['audio']['name'];
            move_uploaded_file($_FILES['audio']['tmp_name'], $naudio);
            $audio->audio = $naudio;
            $audio->idPartitura = $request->idPartitura;

            $res = $audio->save();
            DB::commit();

            return $res;
        } catch (\Exception $e) {

            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function show($id)
    {
        return Audio::find($id);
    }

    public function update(Request $request, $id)
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

        $audio = Audio::find($id);

        if ($validaciones->fails()) {
            return $validaciones->errors()->all();
        }

        try {
            DB::beginTransaction();
            $audio->obra = $request->obra;
            $audio->duracion = $request->duracion;
            $audio->interprete = $request->interprete;
            $naudio = 'audios/' . $_FILES['audio']['name'];
            if ($naudio != "") {
                move_uploaded_file($_FILES['audio']['tmp_name'], $naudio);
                $audio->audio = $naudio;
            }
            $audio->idPartitura = $request->idPartitura;

            $res = $audio->save();

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
        $audio = Audio::find($id);
        if ($audio) {
            $audio->delete();
        }
    }
}
