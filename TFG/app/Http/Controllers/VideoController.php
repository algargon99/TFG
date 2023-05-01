<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    public function mostrarVideos()
    {
        $video = Video::all();
        return view('video', compact('video'));
    }

    public function verCrearVideo()
    {
        return view('verNewVideo');
    }

    public function crearVideo(Request $request)
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
            return redirect()
                ->back()
                ->withErrors($validaciones)
                ->withInput();
        }

        $video = new Video();
        $video->nombre = $request->nombre;
        $video->interprete = $request->interprete;
        $video->year = $request->year;
        $nvideo = 'videos/' . $_FILES['video']['name'];
        move_uploaded_file($_FILES['video']['tmp_name'], $nvideo);
        $video->video = $nvideo;
        $video->idPartitura = $request->idPartitura;

        $video->save();

        return redirect()->route('video.index')->with('success', 'Video creado correctamente');
    }

    public function show(Request $request)
    {
        return view('video.show', compact('video'));
    }

    public function edit(Request $request)
    {
        return view('video.edit', compact('video'));
    }

    public function update(Request $request)
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
            return redirect()
                ->back()
                ->withErrors($validaciones)
                ->withInput();
        }

        $video = Video::find($request->id);

        $video->obra = $request->obra;
        $video->duracion = $request->duracion;
        $video->interprete = $request->interprete;
        $nvideo = 'videos/' . $_FILES['video']['name'];
        if ($nvideo != "") {
            move_uploaded_file($_FILES['video']['tmp_name'], $nvideo);
            $video->video = $nvideo;
        }
        $video->idPartitura = $request->idPartitura;

        $video->save();

        return redirect()->route('video.index')->with('success', 'Video actualizado correctamente');
    }

    public function destroy(Request $request)
    {
        $video = Video::find($request->id);
        $video->delete();

        return redirect()->route('video.index')->with('success', 'Video eliminado correctamente');
    }
}
