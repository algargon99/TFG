<?php

namespace App\Http\Controllers;

use App\Models\Director;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DirectorController extends Controller
{
    // Mostrar la lista de directores
    public function index()
    {
        return Director::with('usuario')->get();
    }

    // Almacenar un nuevo director en la base de datos
    public function store(Request $request)
    {
        $reglas = [
            'nombre' => 'required|string',
            'apellidos' => 'required|string',
            'direccion' => 'required|string',
            'telefono' => 'required|string|regex:/[6|7][0-9]{8}/',
            'correo' => 'required|email',
            'fechaNacimiento' => 'required|date',
            'escuela' => 'required|string',
        ];

        $mensajes = [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'direccion.required' => 'La dirección es obligatoria.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.regex' => 'El teléfono tiene que ser un número de 9 cifras.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'El correo es tiene que ser formato x@x.x.',
            'fechaNacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fechaNacimiento.date' => 'La fecha de nacimiento tiene que ser formato correcto.',
            'escuela.required' => 'La escuela es obligatoria.',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return $validaciones->errors()->all();
        }

        $inputs = $request->input();
        $usuario = new Usuario();
        $usuario->nombre = $inputs["nombre"];
        $usuario->apellidos = $inputs["apellidos"];
        $usuario->direccion = $inputs["direccion"];
        $usuario->telefono = $inputs["telefono"];
        $usuario->correo = $inputs["correo"];
        $usuario->fechaNacimiento = $inputs["fechaNacimiento"];
        $pass  = substr($inputs["nombre"], 0, 3) . substr($inputs["apellidos"], 0, 3);
        $usuario->password = bcrypt($pass);
        $usuario->save();

        $director = new Director();
        $director->escuela = $inputs->escuela;
        $director->idUsuario = $usuario["id"];

        $respuesta = $director->save();
        return $respuesta;
    }

    // Mostrar el detalle de un director
    public function show($id)
    {
        return Director::with('usuario')->find($id);
    }

    // Actualizar la información de un director en la base de datos
    public function update(Request $request, $id)
    {
        $reglas = [
            'nombre' => 'required|string',
            'apellidos' => 'required|string',
            'direccion' => 'required|string',
            'telefono' => 'required|string|regex:/^\d{9}/',
            'correo' => 'required|email',
            'fechaNacimiento' => 'required|date',
            'escuela' => 'required|string',
        ];

        $mensajes = [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'direccion.required' => 'La dirección es obligatoria.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.regex' => 'El teléfono tiene que ser un número de 9 cifras.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'El correo es tiene que ser formato x@x.x.',
            'fechaNacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fechaNacimiento.date' => 'La fecha de naciemiento ha de tener dicho formato fecha',
            'escuela.required' => 'La escuela es obligatoria.',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return $validaciones->errors()->all();
        }
        
        $director = Director::find($id);
        $usuario = Usuario::find($director->idUsuario);
        $inputs = $request->input();
        $usuario->nombre = $inputs["nombre"];
        $usuario->apellidos = $inputs["apellidos"];
        $usuario->direccion = $inputs["direccion"];
        $usuario->telefono = $inputs["telefono"];
        $usuario->correo = $inputs["correo"];
        $usuario->fechaNacimiento = $inputs["fechaNacimiento"];
        $usuario->save();
        $director->escuela = $inputs["escuela"];
        $respuesta = $director->save();
        return $respuesta;
    }

    // Eliminar un director de la base de datos
    public function destroy($id)
    {
        $director = Director::find($id);
        if ($director) {
            $director->delete();
        }
    }
}
