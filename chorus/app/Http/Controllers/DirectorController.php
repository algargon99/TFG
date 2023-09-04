<?php

namespace App\Http\Controllers;

use App\Models\Director;
use App\Models\RelUsuarioCoro;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DirectorController extends Controller
{
    public function index()
    {
        return Director::with('usuario')->get();
    }

    public function store(Request $request)
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
            'fechaNacimiento.date' => 'La fecha de nacimiento tiene que ser formato correcto.',
            'escuela.required' => 'La escuela es obligatoria.',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return $validaciones->errors()->all();
        }


        $inputs = $request->input();

        $user = Usuario::where('correo', $inputs["correo"]);
        if ($user) {
            return ["Ya existe un usuario con este correo", ""];
        }
        
        $usuario = new Usuario();
        $usuario->nombre = $inputs["nombre"];
        $usuario->apellidos = $inputs["apellidos"];
        $usuario->direccion = $inputs["direccion"];
        $usuario->telefono = $inputs["telefono"];
        $usuario->correo = $inputs["correo"];
        $usuario->fechaNacimiento = $inputs["fechaNacimiento"];
        $usuario->archivo = 'img/usuario/icono.png';
        $usuario->admin = 0;
        $pass  = substr($inputs["nombre"], 0, 3) . substr($inputs["apellidos"], 0, 3);
        $usuario->password = bcrypt($pass);

        $director = new Director();
        $director->escuela = $inputs["escuela"];


        DB::beginTransaction();

        try {
            $usuario->save();

            $director->idUsuario = $usuario["id"];
            $res = $director->save();

            DB::commit();

            return $res;
        } catch (\Exception $e) {
            DB::rollback();

            return $e->getMessage();
        }
    }

    public function show($id)
    {
        return Director::with('usuario')->find($id);
    }

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
        $director->escuela = $inputs["escuela"];

        DB::beginTransaction();

        try {
            $usuario->save();

            $res = $director->save();

            DB::commit();

            return $res;
        } catch (\Exception $e) {
            DB::rollback();

            return $e->getMessage();
        }
    }

    public function destroy($id)
    {
        $director = Director::find($id);

        if (isset($director)) {
            $coroUsuarioExists = RelUsuarioCoro::where('usuario_id', $director->idUsuario)->exists();

            $a = 1;
            if ($coroUsuarioExists) {
                $a = RelUsuarioCoro::where('usuario_id', $director->idUsuario)->delete();
            }

            $c = $director->delete();

            $b = Usuario::where('id', $director->idUsuario)->delete();

            if ($a > 0 && $b == 1 && $c == 1) {
                return 1;
            } else {
                return response()->json([
                    'data' => $director,
                    'mensaje' => 'Director no borrado'
                ]);
            }
        } else {
            return response()->json([
                'data' => $director,
                'mensaje' => 'Director no existe'
            ]);
        }
    }
}
