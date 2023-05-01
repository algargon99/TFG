<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $reglas = [
            'nombre' => 'required|string',
            'apellidos' => 'required|string',
            'direccion' => 'required|string',
            'telefono' => 'required|string|regex:/[6|7][0-9]{8}/]',
            'correo' => 'required|email',
            'fechaNacimiento' => 'required|date',
            'password' => 'required|string|regex:/^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8}$/',
            'repetirPass' => 'required|string|same:password',
        ];

        $mensajes = [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'direccion.required' => 'La dirección es obligatoria.',
            'phone.required' => 'El teléfono es obligatorio.',
            'phone.regex' => 'El teléfono tiene que ser un número de 9 cifras que empiece por 6 o 7.',
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'El correo es tiene que ser formato x@x.x.',
            'fechaNacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fechaNacimiento.date' => 'La fecha de naciemiento ha de tener dicho formato fecha',
            'password.required' => 'La contraseña es obligatoria.',
            'password.regex' => 'La contraseña tiene que tener mínimo 8 caractéres con al menos una minúscula, una mayúscula y un número',
            'repetirPass.required' => 'La contraseña repetida es obligatoria.',
            'repetirPass.same' => 'La contraseñas no concuerdan.',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return redirect()
                ->back()
                ->withErrors($validaciones)
                ->withInput();
        }

        Usuario::create($request->all());

        return redirect()->route('usuarios.mostrar')
            ->with('success', 'Usuario creado');
    }

    // Mostrar el detalle de un usuario
    public function verUsuario(Request $request)
    {
        $usuario = Usuario::find($request->id);
        return view('usuarios.usuario', @compact('usuario'));
    }

    // Mostrar el formulario de edición de un usuario
    public function verEditarUsuario(Request $request)
    {
        $usuario = Usuario::find($request->id);
        return view('usuarios.editar', @compact('usuario'));
    }

    // Actualizar la información de un usuario en la base de datos
    public function editarUsuario(Request $request)
    {
        $reglas = [
            'nombre' => 'required|string',
            'apellidos' => 'required|string',
            'direccion' => 'required|string',
            'telefono' => 'required|string|regex:/[6|7][0-9]{8}/]',
            'correo' => 'required|email',
            'fechaNacimiento' => 'required|date',
            'password' => 'required|string|regex:/^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8}$/',
            'repetirPass' => 'required|string|same:password',
        ];

        $mensajes = [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'direccion.required' => 'La dirección es obligatoria.',
            'phone.required' => 'El teléfono es obligatorio.',
            'phone.regex' => 'El teléfono tiene que ser un número de 9 cifras que empiece por 6 o 7.',
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'El correo es tiene que ser formato x@x.x.',
            'fechaNacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fechaNacimiento.date' => 'La fecha de naciemiento ha de tener dicho formato fecha',
            'password.required' => 'La contraseña es obligatoria.',
            'password.regex' => 'La contraseña tiene que tener mínimo 8 caractéres con al menos una minúscula, una mayúscula y un número',
            'repetirPass.required' => 'La contraseña repetida es obligatoria.',
            'repetirPass.same' => 'La contraseñas no concuerdan.',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return redirect()
                ->back()
                ->withErrors($validaciones)
                ->withInput();
        }

        $usuario = Usuario::find($request->id);
        $usuario->update($request->all());

        return redirect()->route('usuarios.mostrar')
            ->with('success', 'Usuario actualizado');
    }

    // Eliminar un usuario de la base de datos
    public function eliminarUsuario(Request $request)
    {
        $usuario = Usuario::find($request->id);
        $usuario->delete();

        return redirect()->route('usuarios.mostrar')
            ->with('success', 'Usuario eliminado');
    }
}
