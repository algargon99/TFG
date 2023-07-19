<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{


    // Actualizar la información de un usuario en la base de datos
    public function update(Request $request, $id)
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



    public function login(Request $request)
    {

        $usuario = Usuario::where('correo', $request->email)->first();
        if (isset($usuario)) {
            if (password_verify($request->password, $usuario->password)) {
                return $usuario->id;
            }
            return "pass";
        }
        return "user";
    }

    public function datosUsuario($id)
    {
        $usuario = Usuario::find($id);

        $cantor = $usuario->cantor;

        if ($cantor) {
            return response()->json(['usuario' => $usuario, 'cantor' => $cantor], 200);
        }

        $director = $usuario->director;

        if ($director) {
            return response()->json(['usuario' => $usuario, 'director' => $director], 200);
        }
        return response()->json(['usuario' => $usuario], 200);
    }

    public function cambiarPass(Request $request, $id)
    {
        $reglas = [
            'pass' => 'required|string|max:255',
            'newpass' => 'required|string|min:8',
            'renewpass' => 'required|string|min:8',
        ];

        $mensajes = [
            'pass.required' => 'La antigua contraseña es obligatorio.',
            'newpass.required' => 'La nueva contraseña es obligatoria.',
            'newpass.min' => 'La nueva contraseña tiene que tener al menos 8 caracteres.',
            'renewpass.required' => 'La nueva contraseña repetida es obligatoria.',
            'renewpass.min' => 'La nueva contraseña repetida tiene que tener al menos 8 caracteres.',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return $validaciones->errors()->all();
        }

        $usuario = Usuario::find($id);
        if (password_verify($request->pass, $usuario->password) && $request->newpass == $request->renewpass) {
            try {
                DB::beginTransaction();
                $usuario->password = bcrypt($request->pass);
                $res = $usuario->save();
                DB::commit();
                return $res;
            } catch (\Exception $e) {
                DB::rollBack();
                return $e->getMessage();
            }
        } elseif (!password_verify($request->pass, $usuario->password)) {
            return ["La contraseña antigua es incorrecta.", ""];
        } elseif ($request->newpass != $request->renewpass) {
            return ["Las contraseñas nuevas no coinciden.", ""];
        }
    }

    public function contacto(Request $request)
    {
        $reglas = [
            'nombre' => 'required|string',
            'apellidos' => 'required|string',
            'email' => 'required|email',
        ];

        $mensajes = [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico no cumple el formato correcto.',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return $validaciones->errors()->all();
        }

        //Crear funcionalidad correo electrónico

        return 1;
    }
}
