<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NotificacionController extends Controller
{
    // GET /notificaciones → genera (si toca) y devuelve JSON para el dropdown
    public function index(Request $request)
    {
        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::user();

        // Perfiles a los que tiene acceso el usuario (creador o invitado)
        $perfilIds = $usuario->perfiles()->pluck('perfil.id_perfil');

        // Ventana de "debido ahora": [-2, +2] minutos (ajústalo si quieres)
        $now  = Carbon::now();
        $from = (clone $now)->subMinutes(2);
        $to   = (clone $now)->addMinutes(2);

        // 1) Generar notificaciones de "toma" para recordatorios debidos y no tomados
        //    Evita duplicar por (usuario, perfil, ts_programada, categoria)
        $debidos = DB::table('recordatorio as r')
            ->join('tratamiento_medicamento as tm', 'tm.id_trat_med', '=', 'r.id_trat_med')
            ->join('tratamiento as t', 't.id_tratamiento', '=', 'tm.id_tratamiento')
            ->join('perfil as p', 'p.id_perfil', '=', 't.id_perfil')
            ->join('medicamento as m', 'm.id_medicamento', '=', 'tm.id_medicamento')
            ->leftJoin('notificacion as n', function ($join) use ($usuario) {
                $join->on('n.ts_programada', '=', 'r.fecha_hora')
                     ->on('n.id_perfil', '=', 'p.id_perfil')
                     ->where('n.categoria', '=', 'toma')
                     ->where('n.id_usuario_dest', '=', $usuario->id_usuario);
            })
            ->whereIn('p.id_perfil', $perfilIds)
            ->whereBetween('r.fecha_hora', [$from, $to])
            // ->whereDate('r.fecha_hora', Carbon::today()) // (opcional) limitar a hoy
            ->where('r.tomado', 0)
            ->whereNull('n.id_notif')
            ->select([
                'r.fecha_hora',
                'p.id_perfil',
                'p.nombre_paciente as perfil',
                'm.nombre as med',
                'tm.dosis',
            ])
            ->get();

        foreach ($debidos as $x) {
            $medStr = trim($x->med);
            $dosisStr = ($x->dosis !== null && $x->dosis !== '') ? ' (' . $x->dosis . ')' : '';
            Notificacion::create([
                'id_usuario_dest' => $usuario->id_usuario,
                'id_perfil'       => $x->id_perfil,
                'categoria'       => 'toma',
                'titulo'          => 'Hora de la medicación',
                'mensaje'         => 'A ' . $x->perfil . ' le toca tomar ' . $medStr . $dosisStr . '.',
                'ts_programada'   => $x->fecha_hora,
                'leida'           => 0,
            ]);
        }

        // 2) Devolver SOLO notificaciones de "toma" para todos los perfiles accesibles
        $noLeidas = Notificacion::where('id_usuario_dest', $usuario->id_usuario)
            ->where('categoria', 'toma')
            ->whereIn('id_perfil', $perfilIds)
            ->where('leida', 0)
            ->orderByDesc('ts_programada')
            ->get();

        $recientes = Notificacion::where('id_usuario_dest', $usuario->id_usuario)
            ->where('categoria', 'toma')
            ->whereIn('id_perfil', $perfilIds)
            ->where('leida', 1)
            ->orderByDesc('ts_programada')
            ->limit(10)
            ->get();

        return response()->json([
            'unread_count' => $noLeidas->count(),
            'unread' => $noLeidas->map(fn($n) => [
                'id'     => $n->id_notif,
                'titulo' => $n->titulo,
                'msg'    => $n->mensaje, // "A [perfil] le toca tomar [medicamento] (dosis)."
                'hora'   => Carbon::parse($n->ts_programada)->format('H:i'),
            ]),
            'recent' => $recientes->map(fn($n) => [
                'id'     => $n->id_notif,
                'titulo' => $n->titulo,
                'msg'    => $n->mensaje,
                'hora'   => Carbon::parse($n->ts_programada)->format('H:i'),
            ]),
        ]);
    }

    // POST /notificaciones/{notificacion}/leer
    public function marcarLeida(Notificacion $notificacion)
    {
        $this->autorizar($notificacion);
        $notificacion->leida = 1;
        $notificacion->save();
        return response()->json(['ok' => true]);
    }

    // POST /notificaciones/leer-todas
    public function marcarTodasLeidas()
    {
        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::user();

        // (Opcional) podrías limitar a perfiles accesibles, pero no es necesario porque
        // todas las notificaciones de "toma" para este usuario ya cumplen esa condición de origen.
        Notificacion::where('id_usuario_dest', $usuario->id_usuario)
            ->where('categoria', 'toma')
            ->where('leida', 0)
            ->update(['leida' => 1]);

        return response()->json(['ok' => true]);
    }

    private function autorizar(Notificacion $n)
    {
        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::user();
        abort_unless($n->id_usuario_dest === $usuario->id_usuario, 403);
    }
}
