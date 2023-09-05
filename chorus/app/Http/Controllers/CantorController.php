<?php

namespace App\Http\Controllers;

use App\Models\Cantor;
use App\Models\RelUsuarioCoro;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CantorController extends Controller
{
    public function index()
    {
        return Cantor::with('usuario')->get();
    }

    public function store(Request $request)
    {
        $reglas = [
            'nombre' => 'required|string',
            'apellidos' => 'required|string',
            'direccion' => 'required|string',
            'telefono' => 'required|string|regex:/^\d{9}$/',
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

        $usuario = new Usuario();
        $user = Usuario::where('correo', $inputs["correo"]);
        if ($user) {
            return ["Ya existe un usuario con este correo", ""];
        }
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

        $cantor = new Cantor();
        $cantor->voz = $inputs["voz"];

        DB::beginTransaction();

        try {
            $usuario->save();

            $cantor->idUsuario = $usuario["id"];
            $res = $cantor->save();

            DB::commit();

            return $res;
        } catch (\Exception $e) {
            DB::rollback();

            return $e->getMessage();
        }
    }

    public function show($id)
    {
        return Cantor::with('usuario')->find($id);
    }

    public function update(Request $request, $id)
    {
        $reglas = [
            'nombre' => 'required|string',
            'apellidos' => 'required|string',
            'direccion' => 'required|string',
            'telefono' => 'required|string|regex:/^\d{9}$/',
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


        $inputs = $request->input();

        DB::beginTransaction();

        try {
            $cantor = Cantor::find($id);

            if (!$cantor) {
                throw new \Exception('Cantor no encontrado');
            }

            $usuario = Usuario::find($cantor->idUsuario);
            $usuario->nombre = $inputs["nombre"];
            $usuario->apellidos = $inputs["apellidos"];
            $usuario->direccion = $inputs["direccion"];
            $usuario->telefono = $inputs["telefono"];
            $usuario->correo = $inputs["correo"];
            $usuario->fechaNacimiento = $inputs["fechaNacimiento"];
            $usuario->save();

            $cantor->voz = $inputs["voz"];
            $res = $cantor->save();

            DB::commit();

            return $res;
        } catch (\Exception $e) {
            DB::rollback();

            return $e->getMessage();
        }
    }

    public function destroy($id)
    {
        $cantor = Cantor::find($id);

        if (isset($cantor)) {
            $coroUsuarioExists = RelUsuarioCoro::where('usuario_id', $cantor->idUsuario)->exists();

            $a = 1;
            if ($coroUsuarioExists) {
                $a = RelUsuarioCoro::where('usuario_id', $cantor->idUsuario)->delete();
            }

            $c = $cantor->delete();

            $b = Usuario::where('id', $cantor->idUsuario)->delete();

            if ($a > 0 && $b == 1 && $c == 1) {
                return 1;
            } else {
                return response()->json([
                    'data' => $cantor,
                    'mensaje' => 'Cantor no borrado'
                ]);
            }
        } else {
            return response()->json([
                'data' => $cantor,
                'mensaje' => 'Cantor no existe'
            ]);
        }
    }
}
