<?php

namespace App\Http\Controllers;

use App\Models\Cantor;
use App\Models\Director;
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

            $rels = RelUsuarioCoro::where('usuario_id', $request->usuario)
                ->where('coro_id', $request->coro)
                ->get();

            if (count($rels) > 0) {
                return ['El usuario ya tiene asignado este coro', ''];
            } else {
                $esCantor = Cantor::where('idUsuario', $request->usuario)->exists();
                $esDirector = Director::where('idUsuario', $request->usuario)->exists();

                $relacion = new RelUsuarioCoro();
                $relacion->usuario_id = $request->usuario;
                $relacion->coro_id = $request->coro;
                $res = $relacion->save();

                if ($request->rol == 'cantor' && !$esCantor && !$esDirector) {
                    if ($request->voz == '') {
                        return ["Escribe una voz",""];
                    }
                    $cantor = new Cantor();
                    $cantor->voz = $request->voz;
                    $cantor->idUsuario = $request->usuario;
                    $res = $cantor->save();
                } elseif ($request->rol == 'director' && !$esDirector && !$esCantor) {
                    if ($request->voz == '') {
                        return ["Escribe una escuela",""];
                    }
                    $director = new Director();
                    $director->escuela = $request->escuela;
                    $director->idUsuario = $request->usuario;
                    $res = $director->save();
                }

                DB::commit();
                return $res;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function desasignarCoro(Request $request)
    {
        try {
            DB::beginTransaction();
            $relacion = RelUsuarioCoro::where('usuario_id', $request->usuario)->where('coro_id', $request->coro)->first();
            $res = $relacion;
            if (isset($relacion)) {
                $res = RelUsuarioCoro::destroy($relacion->id);
            }
            DB::commit();
            return $res;
        } catch (\Exception $e) {

            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function estaCoro($idCoro, $idUsuario)
    {
        $relacion = RelUsuarioCoro::where('usuario_id', $idUsuario)->where('coro_id', $idCoro)->first();
        if ($relacion != '') {
            return 1;
        } else {
            return 0;
        }
    }
}
