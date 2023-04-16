<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    
    // Mostrar la lista de usuarios
    public function mostrarUsuarios()
    {
        $usuarios = Usuario::all();
        return view('usuarios.mostrar', @compact('usuarios'));
    }

    // Mostrar el formulario de creación de usuario
    public function verCrearUsuario()
    {
        return view('usuarios.crear');
    }

    // Almacenar un nuevo usuario en la base de datos
    public function crearUsuario(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'apellidos' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'correo' => 'required|email',
            'fechaNacimiento' => 'required|date',
        ]);

        Usuario::create($request->all());

        return redirect()->route('usuarios.mostrar')
            ->with('success', 'Usuario creado');
    }

    // Mostrar el detalle de un usuario
    public function verUsuario(Request $request)
    {
        $usuario = Usuario::findOrFail($request->id);
        return view('usuarios.usuario', @compact('usuario'));
    }

    // Mostrar el formulario de edición de un usuario
    public function verEditarUsuario(Request $request)
    {
        $usuario = Usuario::findOrFail($request->id);
        return view('usuarios.editar', @compact('usuario'));
    }

    // Actualizar la información de un usuario en la base de datos
    public function editarUsuario(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'apellidos' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'correo' => 'required|email',
            'fechaNacimiento' => 'required|date',
        ]);

        $usuario = Usuario::findOrFail($request->id);
        $usuario->update($request->all());

        return redirect()->route('usuarios.mostrar')
            ->with('success', 'Usuario actualizado');
    }

    // Eliminar un usuario de la base de datos
    public function eliminarUsuario(Request $request)
    {
        $usuario = Usuario::findOrFail($request->id);
        $usuario->delete();

        return redirect()->route('usuarios.mostrar')
            ->with('success', 'Usuario eliminado');
    }
}