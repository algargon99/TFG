<?php

namespace App\Http\Controllers;

use App\Models\Cantor;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;

class CantorController extends Controller
{
    // Mostrar la lista de cantores
    public function index()
    {
        return Cantor::with('usuario')->get();
    }

    // Almacenar un nuevo cantor en la base de datos
    public function store(Request $request)
    {
        $reglas = [
            'nombre' => 'required|string',
            'apellidos' => 'required|string',
            'direccion' => 'required|string',
            'telefono' => 'required|string|regex:/[6|7][0-9]{8}/',
            'correo' => 'required|email',
            'fechaNacimiento' => 'required|date',
            'voz' => 'required|string',
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
            'voz.required' => 'La voz es obligatoria.',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return $validaciones->errors()->all();
        }

        $inputs = $request->input();
        $usuario = New Usuario();
        $usuario->nombre = $inputs["nombre"];
        $usuario->apellidos = $inputs["apellidos"];
        $usuario->direccion = $inputs["direccion"];
        $usuario->telefono = $inputs["telefono"];
        $usuario->correo = $inputs["correo"];
        $usuario->fechaNacimiento = $inputs["fechaNacimiento"];
        $pass  = substr($inputs["nombre"], 0, 3) . substr($inputs["apellidos"], 0, 3);
        $usuario->password = bcrypt($pass);
        $usuario->save();
        
        $cantor = new Cantor();
        $cantor->voz = $inputs["voz"];
        $cantor->idUsuario = $usuario["id"];

        $respuesta = $cantor->save();
        return $respuesta;

    }

    // Mostrar el detalle de un cantor
    public function show($id)
    {
        return Cantor::with('usuario')->find($id);
    }

    // Actualizar la información de un cantor en la base de datos
    public function update(Request $request, $id)
    {
        $reglas = [
            'nombre' => 'required|string',
            'apellidos' => 'required|string',
            'direccion' => 'required|string',
            'telefono' => 'required|string|regex:/[6|7][0-9]{8}/',
            'correo' => 'required|email',
            'voz' => 'required|string',
        ];

        $mensajes = [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'direccion.required' => 'La dirección es obligatoria.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.regex' => 'El teléfono tiene que ser un número de 9 cifras.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'El correo es tiene que ser formato x@x.x.',
            'voz.required' => 'La voz es obligatoria.',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return $validaciones->errors()->all();
        }

        $cantor = Cantor::find($id);
        $usuario = Usuario::find($cantor->idUsuario);
        $inputs = $request->input();
        $usuario->nombre = $inputs["nombre"];
        $usuario->apellidos = $inputs["apellidos"];
        $usuario->direccion = $inputs["direccion"];
        $usuario->telefono = $inputs["telefono"];
        $usuario->correo = $inputs["correo"];
        $usuario->fechaNacimiento = $inputs["fechaNacimiento"];
        $usuario->save();
        $cantor->voz = $inputs["voz"];
        $respuesta = $cantor->save();
        return $respuesta;
       
    }

    // Eliminar un cantor de la base de datos
    public function destroy($id)
    {
        $cantor = Cantor::find($id);
        if ($cantor) {
            $cantor->delete();
        }
    }
}
