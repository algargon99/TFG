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
        if ($partitura) {
            return $partitura->audios;
        } else {
            return "Nada";
        }
    }

    public function store(Request $request, $id)
    {

        $reglas = [
            'obra' => 'required|string|max:255',
            'voz' => 'required|string|max:255',
            'duracion' => 'required|integer|min:1',
            'interprete' => 'required|string|max:255'
        ];

        $mensajes = [
            'obra.required' => 'El nombre de la obra es obligatorio.',
            'voz.required' => 'La voz de la obra es obligatoria.',
            'duracion.required' => 'La duración es obligatoria.',
            'duracion.integer' => 'La duración ha de ser un número entero.',
            'duracion.min' => 'La duración tiene que ser mínimo de 1 minuto.',
            'interprete.required' => 'El interprete es obligatorio.',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return $validaciones->errors()->all();
        }

        try {
            DB::beginTransaction();
            $audio = new Audio();
            $audio->obra = $request->obra;
            $audio->voz = $request->voz;
            $audio->duracion = $request->duracion;
            $audio->interprete = $request->interprete;

            if ($request->hasFile('archivo')) {
                $archivo = $request->file('archivo');
                $archivo->move(public_path('audio'), 'audio' . time() . '.mp3');
                $audio->audio = 'audio/' . 'audio' . time() . '.mp3';
            }
            $audio->idPartitura = $id;

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
            'voz' => 'required|string|max:255',
            'duracion' => 'required|integer|min:1',
            'interprete' => 'required|string|max:255',
        ];

        $mensajes = [
            'obra.required' => 'El nombre de la obra es obligatorio.',
            'voz.required' => 'La voz de la obra es obligatoria.',
            'duracion.required' => 'La duración es obligatoria.',
            'duracion.integer' => 'La duración ha de ser un número entero.',
            'duracion.min' => 'La duración tiene que ser mínimo de 1 minuto.',
            'interprete.required' => 'El interprete es obligatorio.',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        $audio = Audio::find($id);

        if ($validaciones->fails()) {
            return $validaciones->errors()->all();
        }

        try {
            DB::beginTransaction();
            $audio->obra = $request->obra;
            $audio->voz = $request->voz;
            $audio->duracion = $request->duracion;
            $audio->interprete = $request->interprete;
            if ($request->hasFile('archivo')) {
                $archivo = $request->file('archivo');
                $archivo->move(public_path('audio'), 'audio' . time() . '.mp3');
                $audio->audio = 'audio/' . 'audio' . time() . '.mp3';
            }

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
        if (isset($audio)) {

            $res = Audio::destroy($id);
            if ($res) {
                return 1;
            } else {
                return response()->json([
                    'data' => $audio,
                    'mensaje' => 'Audio no borrado'
                ]);
            }
        } else {
            return response()->json([
                'data' => $audio,
                'mensaje' => 'Audio no existe'
            ]);
        }
    }
}
