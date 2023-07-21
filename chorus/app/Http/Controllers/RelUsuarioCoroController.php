<?php

namespace App\Http\Controllers;

use App\Models\RelUsuarioCoro;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelUsuarioCoroController extends Controller
{

    public function asignarCoro(Request $request)
    {

        try {

            DB::beginTransaction();

            $rels = RelUsuarioCoro::where('usuario_id', $request->usuario)->where('coro_id', $request->coro)->get();
            if (count($rels) > 0) {
                return ['El usuario ya tiene asignado este coro', ''];
            } else {
                $relacion = new RelUsuarioCoro;
                $relacion->usuario_id = $request->usuario;
                $relacion->coro_id = $request->coro;
                $res = $relacion->save();

                DB::commit();

                return $res;
            }
        } catch (\Exception $e) {

            DB::rollBack();
            return $e->getMessage();
        }
    }
}
