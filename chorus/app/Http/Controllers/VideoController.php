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
        return $partitura->audios;
    }

    public function store(Request $request)
    {

        $reglas = [
            'nombre' => 'required|string',
            'interprete' => 'required|string',
            'year' => 'required|integer|min:0',
            'video' => 'required|mimetypes:video/*',
        ];

        $mensajes = [
            'nombre.required' => 'El nombre del vídeo es obligatorio.',
            'interprete.required' => 'El intérprete es obligatorio.',
            'year.required' => 'El año es obligatorio.',
            'year.integer' => 'El año del vídeo tiene que ser numérico.',
            'year.min' => 'El año del vídeo tiene que ser al menos el año 0.',
            'video.required' => 'El video es obligatorio',
            'video.mimetypes' => 'El tipo de archivo tiene que ser de vídeo',
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
            $nvideo = 'videos/' . $_FILES['video']['name'];
            move_uploaded_file($_FILES['video']['tmp_name'], $nvideo);
            $video->video = $nvideo;
            $video->idPartitura = $request->idPartitura;


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
            'year' => 'required|integer|min:0',
            'video' => 'mimetypes:video/*',
        ];

        $mensajes = [
            'nombre.required' => 'El nombre del vídeo es obligatorio.',
            'interprete.required' => 'El intérprete es obligatorio.',
            'year.required' => 'El año es obligatorio.',
            'year.integer' => 'El año del vídeo tiene que ser numérico.',
            'year.min' => 'El año del vídeo tiene que ser al menos el año 0.',
            'video.mimetypes' => 'El tipo de archivo tiene que ser de vídeo',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return $validaciones->errors()->all();
        }

        $video = Video::find($id);

        try {
            DB::beginTransaction();
            $video->obra = $request->obra;
            $video->duracion = $request->duracion;
            $video->interprete = $request->interprete;
            $nvideo = 'videos/' . $_FILES['video']['name'];
            if ($nvideo != "") {
                move_uploaded_file($_FILES['video']['tmp_name'], $nvideo);
                $video->video = $nvideo;
            }
            $video->idPartitura = $request->idPartitura;
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
        if ($video) {
            $video->delete();
        }
    }
}
