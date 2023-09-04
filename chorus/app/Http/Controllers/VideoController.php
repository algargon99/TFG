<?php

namespace App\Http\Controllers;

use App\Models\Partitura;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    public function index($id)
    {
        $partitura = Partitura::find($id);
        if ($partitura) {
            return $partitura->videos;
        } else {
            return "Nada";
        }
    }

    public function store(Request $request, $id)
    {

        $reglas = [
            'nombre' => 'required|string',
            'interprete' => 'required|string',
            'year' => 'required|integer|min:0|max:2023',
            'archivo' => 'required|mimes:mp4,avi,mov|max:2048',
        ];

        $mensajes = [
            'nombre.required' => 'El nombre del vídeo es obligatorio.',
            'interprete.required' => 'El intérprete es obligatorio.',
            'year.required' => 'El año es obligatorio.',
            'year.integer' => 'El año del vídeo tiene que ser numérico.',
            'year.min' => 'El año del vídeo tiene que ser al menos el año 0.',
            'year.max' => 'El año del vídeo tiene que ser como mucho el año 2023.',
            'archivo.required' => 'El archivo es obligatorio.',
            'archivo.mimes' => 'El archivo tiene que ser un vídeo',
            'archivo.max' => 'El archivo debe pesar como máximo de 2 MB'
            
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        $video = new Video();

        if ($validaciones->fails()) {
            return $validaciones->errors()->all();
        }

        try {
            DB::beginTransaction();
            $video = new Video();
            $video->nombre = $request->nombre;
            $video->interprete = $request->interprete;
            $video->year = $request->year;
            if ($request->hasFile('archivo')) {
                $archivo = $request->file('archivo');
                $archivo->move(public_path('video'), 'video' . time() . '.mp4');
                $video->video = 'video/' . 'video' . time() . '.mp4';
            }
            $video->idPartitura = $id;


            $res = $video->save();
            DB::commit();

            return $res;
        } catch (\Exception $e) {

            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function show($id)
    {
        return Video::find($id);
    }


    public function update(Request $request, $id)
    {
        $reglas = [
            'nombre' => 'required|string',
            'interprete' => 'required|string',
            'year' => 'required|integer|min:0|max:2023',
            'archivo' => 'mimes:mp4,avi,mov|max:2048',
        ];

        $mensajes = [
            'nombre.required' => 'El nombre del vídeo es obligatorio.',
            'interprete.required' => 'El intérprete es obligatorio.',
            'year.required' => 'El año es obligatorio.',
            'year.integer' => 'El año del vídeo tiene que ser numérico.',
            'year.min' => 'El año del vídeo tiene que ser al menos el año 0.',
            'year.max' => 'El año del vídeo tiene que ser como mucho el año 2023.',
            'archivo.mimes' => 'El archivo tiene que ser un vídeo',
            'archivo.max' => 'El archivo debe pesar como máximo de 2 MB'
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return $validaciones->errors()->all();
        }

        $video = Video::find($id);

        try {
            DB::beginTransaction();
            $video->nombre = $request->nombre;
            $video->interprete = $request->interprete;
            $video->year = $request->year;
            if ($request->hasFile('archivo')) {
                $archivo = $request->file('archivo');
                $archivo->move(public_path('video'), 'video' . time() . '.mp4');
                $video->video = 'video/' . 'video' . time() . '.mp4';
            }
            $res = $video->save();
            DB::commit();
            return $res;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {
        $video = Video::find($id);
        if (isset($video)) {

            $res = Video::destroy($id);
            if ($res) {
                return 1;
            } else {
                return response()->json([
                    'data' => $video,
                    'mensaje' => 'Video no borrado'
                ]);
            }
        } else {
            return response()->json([
                'data' => $video,
                'mensaje' => 'Video no existe'
            ]);
        }
    }
}
