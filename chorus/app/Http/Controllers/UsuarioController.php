<?php

namespace App\Http\Controllers;

use App\Mail\ContactoMail;
use App\Models\RelUsuarioCoro;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    // Actualizar la información de un usuario en la base de datos
    public function editarPerfil(Request $request, $id)
    {
        $reglas = [
            'nombre' => 'required|string',
            'apellidos' => 'required|string',
            'direccion' => 'required|string',
            'telefono' => 'required|string|regex:/^\d{9}/',
            'correo' => 'required|email',
            'fechaNacimiento' => 'required|date',

        ];

        $mensajes = [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'direccion.required' => 'La dirección es obligatoria.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.regex' => 'El teléfono tiene que ser un número que empiece por 6 o 7.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'El correo es tiene que ser formato x@x.x.',
            'fechaNacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fechaNacimiento.date' => 'La fecha de naciemiento ha de tener dicho formato fecha',
        ];


        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return $validaciones->errors()->all();
        }

        $usuario = Usuario::find($id);

        DB::beginTransaction();

        try {
            $usuario->nombre = $request->nombre;
            $usuario->apellidos = $request->apellidos;
            $usuario->direccion = $request->direccion;
            $usuario->correo = $request->correo;
            $usuario->telefono = $request->telefono;
            $usuario->fechaNacimiento = $request->fechaNacimiento;
            $res = $usuario->save();
            DB::commit();
            return $res;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function login(Request $request)
    {

        $usuario = Usuario::where('correo', $request->email)->first();
        if (isset($usuario)) {
            if (password_verify($request->password, $usuario->password)) {
                $res = [$usuario->id];
                if ($usuario->admin == 1) {
                    array_push($res, $usuario->admin);
                } elseif ($usuario->cantor) {
                    array_push($res, '3');
                } elseif ($usuario->director) {
                    array_push($res, '2');
                } else {
                    array_push($res, '0');
                }
                array_push($res, $usuario->archivo);
                return $res;
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
            'id' => 'required',
            'coro' => 'required',
            'comentario' => 'required|string',

        ];

        $mensajes = [
            'id.required' => 'No está registrado.',
            'coro.required' => 'El nombre es obligatorio.',
            'comentario.required' => 'Los apellidos son obligatorios.',

        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return $validaciones->errors()->all();
        }

        //Directores del coro
        $controladorCoro = new CoroController();
        $directores = $controladorCoro->directoresCoro($request->coro);

        $usuario = Usuario::find($request->id);
        $correo = $usuario->correo;
        $nombre = $usuario->nombre . ' ' . $usuario->apellidos;
        $comentario = $request->comentario;

        //Enviar correos
        foreach ($directores as $director) {
            // Aquí envías el correo a cada director
            $nombreD = $director->nombre;
            $correoD = $director->correo;
            $mail = new ContactoMail($comentario, $correoD, $nombreD, $correo, $nombre);
            Mail::send($mail);
        }

        return 1;
    }

    public function usuarios()
    {
        $usuarios = Usuario::all();
        if ($usuarios) {
            return $usuarios;
        }
    }

    public function cambiarImagen(Request $request, $id)
    {
        $reglas = [
            'archivo' => 'mimes:png,jpg'
        ];

        $mensajes = [
            'archivo.mimes' => 'El archivo tiene que ser PNG o JPG' 
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return $validaciones->errors()->all();
        }

        
        try {
            DB::beginTransaction();

            $usuario = Usuario::find($id);
            if ($request->hasFile('imagen')) {
                $archivo = $request->file('imagen');
                $archivo->move(public_path('img/usuario'), 'usuario' . $id . '.png');
                $usuario->archivo = 'img/usuario/' . 'usuario' . $id . '.png';
            }
            $res = $usuario->save();

            DB::commit();
            return $res;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }

        return 1;
    }

    public function cuenta(Request $request)
    {
        $reglas = [
            'nombre' => 'required|string',
            'apellidos' => 'required|string',
            'direccion' => 'required|string',
            'telefono' => 'required|string|regex:/^\d{9}/',
            'correo' => 'required|email',
            'fechaNacimiento' => 'required|date',
            'pass' => 'required|string|min:8',
            'repass' => 'required|string|min:8',

        ];

        $mensajes = [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'direccion.required' => 'La dirección es obligatoria.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.regex' => 'El teléfono tiene que ser un número que empiece por 6 o 7.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'El correo es tiene que ser formato x@x.x.',
            'fechaNacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fechaNacimiento.date' => 'La fecha de naciemiento ha de tener dicho formato fecha',
            'pass.required' => 'La contraseña es obligatoria.',
            'pass.min' => 'La contraseña tiene que tener al menos 8 caracteres.',
            'repass.required' => 'La contraseña repetida es obligatoria.',
            'repass.min' => 'La contraseña repetida tiene que tener al menos 8 caracteres.',
        ];


        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return $validaciones->errors()->all();
        }

        $usuario = new Usuario();
        if ($request->pass == $request->repass) {
            DB::beginTransaction();
            try {
                $usuario->nombre = $request->nombre;
                $usuario->apellidos = $request->apellidos;
                $usuario->direccion = $request->direccion;
                $usuario->correo = $request->correo;
                $usuario->telefono = $request->telefono;
                $usuario->fechaNacimiento = $request->fechaNacimiento;
                $usuario->password = bcrypt($request->pass);
                $usuario->archivo = 'img/usuario/icono.png';
                $usuario->admin = 0;
                $usuario->save();
                DB::commit();
                return $usuario->id;
            } catch (\Exception $e) {
                DB::rollback();
                return $e->getMessage();
            }
        } elseif ($request->newpass != $request->renewpass) {
            return ["Las contraseñas nuevas no coinciden.", ""];
        }
    }

    public function eliminarCuenta(Request $request)
    {

        try {
            DB::beginTransaction();
            $rels = RelUsuarioCoro::where('usuario_id', $request->id)->get();

            foreach ($rels as $rel) {
                $rel->delete();
            }

            $usuario = Usuario::find($request->id);
            $cantor = $usuario->cantor;

            if ($cantor) {
                $cantor->delete();
            }

            $director = $usuario->director;

            if ($director) {
                $director->delete();
            }

            $res = $usuario->delete();
            DB::commit();
            return $res;
        } catch (\Exception $e) {

            DB::rollBack();
            return $e->getMessage();
        }
    }
}
