<?php

namespace App\Http\Controllers;

use App\Models\Coro;
use Illuminate\Http\Request;

class CoroController extends Controller
{
    // Mostrar la lista de coros
    public function mostrarCoros()
    {
        $coros = Coro::all();
        return view('coros.mostrar', @compact('coros'));
    }

    // Mostrar el formulario de creación de un coro
    public function verCrearCoro()
    {
        return view('coros.crear');
    }

    // Almacenar un nuevo coro en la base de datos
    public function crearCoro(Request $request)
    {

        Coro::create($request->all());

        return redirect()->route('coros.mostrar')
            ->with('success', 'Coro creado');
    }

    public function verCoro(Request $request)
    {
        $coro = Coro::findOrFail($request->id);
        return view('coros.coro', @compact('coro'));
    }

    public function verEditarUsuario(Request $request)
    {
        $coro = Coro::findOrFail($request->id);
        return view('coros.editar', @compact('coro'));
    }

    public function editarCoro(Request $request)
    {
        $usuario = Coro::findOrFail($request->id);
        $usuario->update($request->all());

        return redirect()->route('coros.mostrar')
            ->with('success', 'Coro actualizaoo');
    }

    public function eliminarCoro(Request $request)
    {
        $coro = Coro::findOrFail($request->id);
        $coro->delete();

        return redirect()->route('coros.mostrar')
            ->with('success', 'Coro eliminado');
    }
}