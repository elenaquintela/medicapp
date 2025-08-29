<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NotificacionController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::user();

        $perfilIds = $usuario->perfiles->pluck('id_perfil');

        $tz    = config('app.timezone');
        $today = \Carbon\Carbon::today($tz);
        $now   = \Carbon\Carbon::now($tz);

        $from = (clone $now)->subSeconds(30);
        $to   = (clone $now);

        $debidos = DB::table('recordatorio as r')
            ->join('tratamiento_medicamento as tm', 'tm.id_trat_med', '=', 'r.id_trat_med')
            ->join('tratamiento as t', 't.id_tratamiento', '=', 'tm.id_tratamiento')
            ->join('perfil as p', 'p.id_perfil', '=', 't.id_perfil')
            ->join('medicamento as m', 'm.id_medicamento', '=', 'tm.id_medicamento')
            ->leftJoin('notificacion as n', function ($join) use ($usuario) {
                $join->on('n.ts_programada', '=', 'r.fecha_hora')
                    ->on('n.id_perfil', '=', 'p.id_perfil')
                    ->where('n.categoria', 'toma')
                    ->where('n.id_usuario_dest', $usuario->id_usuario);
            })
            ->whereIn('p.id_perfil', $perfilIds)
            ->where('tm.estado', 'activo')
            ->whereDate('r.fecha_hora', $today)
            ->whereBetween('r.fecha_hora', [$from, $to])  
            ->where('r.tomado', 0)
            ->whereNull('n.id_notif')
            ->select(['r.fecha_hora', 'p.id_perfil', 'p.nombre_paciente as perfil', 'm.nombre as med', 'tm.dosis'])
            ->get();

        foreach ($debidos as $x) {
            \App\Models\Notificacion::create([
                'id_usuario_dest' => $usuario->id_usuario,
                'id_perfil'       => $x->id_perfil,
                'categoria'       => 'toma',
                'titulo'          => 'Hora de la medicación',
                'mensaje'         => 'A ' . $x->perfil . ' le toca tomar ' . trim($x->med) . ($x->dosis ? ' (' . $x->dosis . ')' : '') . '.',
                'ts_programada'   => $x->fecha_hora,
                'leida'           => 0,
            ]);
        }

        $debidosCita = DB::table('cita as c')
            ->join('perfil as p', 'p.id_perfil', '=', 'c.id_perfil')
            ->leftJoin('notificacion as n2', function ($join) use ($usuario) {
                $join->on('n2.id_perfil', '=', 'p.id_perfil')
                    ->where('n2.categoria', 'cita')
                    ->where('n2.id_usuario_dest', $usuario->id_usuario)
                    ->on('n2.ts_programada', '=', DB::raw("DATE_SUB(CONCAT(c.fecha, ' ', c.hora_inicio), INTERVAL 30 MINUTE)"));
            })
            ->whereIn('p.id_perfil', $perfilIds)
            ->whereDate('c.fecha', $today)
            ->whereBetween(
                DB::raw("DATE_SUB(CONCAT(c.fecha, ' ', c.hora_inicio), INTERVAL 30 MINUTE)"),
                [$from->toDateTimeString(), $to->toDateTimeString()]
            )
            ->whereNull('n2.id_notif')
            ->select([
                'p.id_perfil',
                'p.nombre_paciente as perfil',
                DB::raw("TIME_FORMAT(c.hora_inicio, '%H:%i') as hora_str"),
                DB::raw("DATE_SUB(CONCAT(c.fecha, ' ', c.hora_inicio), INTERVAL 30 MINUTE) as ts_prog"),
            ])
            ->get();

        foreach ($debidosCita as $x) {
            \App\Models\Notificacion::create([
                'id_usuario_dest' => $usuario->id_usuario,
                'id_perfil'       => $x->id_perfil,
                'categoria'       => 'cita',
                'titulo'          => 'Recordatorio de cita',
                'mensaje'         => "{$x->perfil} tiene cita hoy a las {$x->hora_str}.",
                'ts_programada'   => $x->ts_prog,
                'leida'           => 0,
            ]);
        }
        $noLeidas = \App\Models\Notificacion::where('id_usuario_dest', $usuario->id_usuario)
            ->whereIn('categoria', ['toma', 'cita'])
            ->whereIn('id_perfil', $perfilIds)
            ->where('leida', 0)
            ->orderByDesc('ts_programada')
            ->get();

        return response()->json([
            'unread_count' => $noLeidas->count(),
            'unread' => $noLeidas->map(fn($n) => [
                'id'     => $n->id_notif,
                'titulo' => $n->titulo,
                'msg'    => $n->mensaje,
                'hora'   => \Carbon\Carbon::parse($n->ts_programada, $tz)->format('H:i'),
            ]),
            'recent' => [], 
        ]);
    }

    public function marcarLeida(Notificacion $notificacion)
    {
        $this->autorizar($notificacion);
        $notificacion->leida = 1;
        $notificacion->save();
        return response()->json(['ok' => true]);
    }

    public function marcarTodasLeidas()
    {
        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::user();

        Notificacion::where('id_usuario_dest', $usuario->id_usuario)
            ->whereIn('categoria', ['toma', 'cita']) 
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