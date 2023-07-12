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
            'telefono' => 'required|string|regex:/^\d{9}/',
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
        $usuario->nombre = $inputs["nombre"];
        $usuario->apellidos = $inputs["apellidos"];
        $usuario->direccion = $inputs["direccion"];
        $usuario->telefono = $inputs["telefono"];
        $usuario->correo = $inputs["correo"];
        $usuario->fechaNacimiento = $inputs["fechaNacimiento"];
        $pass  = substr($inputs["nombre"], 0, 3) . substr($inputs["apellidos"], 0, 3);
        $usuario->password = bcrypt($pass);

        $cantor = new Cantor();
        $cantor->voz = $inputs["voz"];

        // Inicia la transacción
        DB::beginTransaction();

        try {
            // Inserta el registro del usuario
            $usuario->save();

            // Asigna el ID del usuario al cantor y guarda el registro del cantor
            $cantor->idUsuario = $usuario["id"];
            $res = $cantor->save();

            // Si todas las operaciones se han completado correctamente, se realiza el commit
            DB::commit();

            return $res;
        } catch (\Exception $e) {
            // Si se produce un error, se realiza el rollback para revertir todas las operaciones
            DB::rollback();

            return $e->getMessage();
        }
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
            'telefono' => 'required|string|regex:/^\d{9}/',
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

        // Iniciar la transacción
        DB::beginTransaction();

        try {
            // Buscar el cantor por ID
            $cantor = Cantor::find($id);

            // Verificar si el cantor existe
            if (!$cantor) {
                throw new \Exception('Cantor no encontrado');
            }

            // Actualizar los datos del usuario relacionado al cantor
            $usuario = Usuario::find($cantor->idUsuario);
            $usuario->nombre = $inputs["nombre"];
            $usuario->apellidos = $inputs["apellidos"];
            $usuario->direccion = $inputs["direccion"];
            $usuario->telefono = $inputs["telefono"];
            $usuario->correo = $inputs["correo"];
            $usuario->fechaNacimiento = $inputs["fechaNacimiento"];
            $usuario->save();

            // Actualizar la voz del cantor
            $cantor->voz = $inputs["voz"];
            $res = $cantor->save();

            // Confirmar la transacción
            DB::commit();

            return $res;
        } catch (\Exception $e) {
            // Si se produce un error, realizar el rollback para revertir todas las operaciones
            DB::rollback();

            return $e->getMessage();
        }
    }

    // Eliminar un cantor de la base de datos
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
