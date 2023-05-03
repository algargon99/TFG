<?php

namespace App\Http\Controllers;

use App\Models\RelUsuarioCoro;
use Illuminate\Http\Request;

class RelUsuarioCoroController extends Controller
{
    public function mostrarRelaciones()
    {
        $relaciones = RelUsuarioCoro::all();

        return view('relacion.index', compact('relaciones'));
    }

    public function verCrearRelacion()
    {
        return view('relacion.create');
    }

    public function crearRelacion(Request $request)
    {
        $relacion = new RelUsuarioCoro;

        $relacion->usuario_id = $request->usuario_id;
        $relacion->coro_id = $request->coro_id;

        $relacion->save();

        return redirect()->route('relacion.index');
    }

    public function verRelacion(Request $request)
    {
        $relacion = RelUsuarioCoro::find($request->id);

        return view('relacion.show', compact('relacion'));
    }

    public function verEditarRelacion(Request $request)
    {
        $relacion = RelUsuarioCoro::find($request->id);

        return view('relacion.edit', compact('relacion'));
    }

    public function editarRelacion(Request $request)
    {
        $relacion = RelUsuarioCoro::find($request->id);

        $relacion->usuario_id = $request->usuario_id;
        $relacion->coro_id = $request->coro_id;

        $relacion->save();

        return redirect()->route('relacion.index');
    }

    public function eliminarRelacion(Request $request)
    {
        $relacion = RelUsuarioCoro::find($request->id);

        $relacion->delete();

        return redirect()->route('relacion.index');
    }
}
