<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use Google\Client;
use Google\Service\Calendar;
use Carbon\Carbon;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class GoogleCalendarController extends Controller
{
    private function googleClient(bool $forceSelectAccount = false): Client
    {
        $client = new Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->setAccessType('offline');

        // para que Google muestre el selector de cuentas
        $client->setPrompt($forceSelectAccount ? 'consent select_account' : 'consent');

        $client->setScopes(['https://www.googleapis.com/auth/calendar.events']);
        $client->setHttpClient(new \GuzzleHttp\Client(['verify' => 'C:/PHP/extras/ssl/cacert.pem']));
        return $client;
    }


    private function ensurePremium(Request $request): void
    {
        $u = $request->user();
        abort_if(!$u || $u->rol_global !== 'premium', 403, 'Solo usuarios premium.');
    }

    private function getCalendar(Request $request): Calendar
    {
        $user = $request->user();
        abort_if(empty($user->google_oauth_tokens), 403, 'Conecta tu Google primero.');

        $client = $this->googleClient();

        // Acepta tanto array (cast) como JSON string
        $tokens = is_array($user->google_oauth_tokens)
            ? $user->google_oauth_tokens
            : (json_decode((string)$user->google_oauth_tokens, true) ?: []);

        $client->setAccessToken($tokens);

        if ($client->isAccessTokenExpired()) {
            // Intentar refrescar usando el refresh_token guardado (si no viene en el access token actual)
            $refreshToken = $client->getRefreshToken();
            if (!$refreshToken) {
                $refreshToken = $tokens['refresh_token'] ?? null;
            }

            abort_if(empty($refreshToken), 403, 'La sesión de Google ha caducado. Vuelve a autorizar.');

            $client->fetchAccessTokenWithRefreshToken($refreshToken);

            // Guardar nuevos tokens, asegurando que preservamos el refresh_token
            $newTokens = $client->getAccessToken();
            if (!isset($newTokens['refresh_token'])) {
                $newTokens['refresh_token'] = $refreshToken;
            }
            $user->google_oauth_tokens = $newTokens;
            $user->save();
        }

        return new Calendar($client);
    }

    private function upsertEvent(Request $request, Cita $cita): string
    {
        $service = $this->getCalendar($request);
        $tz = env('GOOGLE_CALENDAR_TIMEZONE', 'Europe/Madrid');

        $startDT = \Carbon\Carbon::parse($cita->fecha . ' ' . $cita->hora_inicio, $tz);
        $endDT = $cita->hora_fin
            ? \Carbon\Carbon::parse($cita->fecha . ' ' . $cita->hora_fin, $tz)
            : (clone $startDT)->addHour();

        $payload = [
            'summary'     => $cita->motivo ?: 'Cita médica',
            'location'    => $cita->ubicacion ?: null,
            'description' => $cita->observaciones ?: null,
            'start'       => ['dateTime' => $startDT->toRfc3339String(), 'timeZone' => $tz],
            'end'         => ['dateTime' => $endDT->toRfc3339String(),   'timeZone' => $tz],
        ];

        // Si tenemos event_id, intentamos UPDATE directo; si falla por "no existe", INSERT.
        if (!empty($cita->google_event_id)) {
            try {
                $event = new \Google\Service\Calendar\Event($payload);
                $updated = $service->events->update('primary', $cita->google_event_id, $event);
                return $updated->id;
            } catch (\Google\Service\Exception $e) {
                if ($this->eventMissingInGoogle($e)) {
                    // recrear
                    $created = $service->events->insert('primary', new \Google\Service\Calendar\Event($payload));
                    return $created->id;
                }
                throw $e; // otro error: lo propagamos
            }
        }

        // No había event_id -> crear
        $created = $service->events->insert('primary', new \Google\Service\Calendar\Event($payload));
        return $created->id;
    }


    /** Comprobar que el usuario pertenece al perfil indicado (creador o invitado). */
    private function userOwnsPerfil(Request $request, int $perfilId): bool
    {
        return DB::table('usuario_perfil')
            ->where('id_usuario', $request->user()->id_usuario)
            ->where('id_perfil', $perfilId)
            ->exists();
    }

    /** Sincroniza todas las citas de un perfil y devuelve cuántas. */
    private function syncPerfil(Request $request, int $perfilId): int
    {
        abort_if(!$this->userOwnsPerfil($request, $perfilId), 403);

        $citas = Cita::where('id_perfil', $perfilId)->get();
        $n = 0;
        foreach ($citas as $cita) {
            try {
                $eventId = $this->upsertEvent($request, $cita);
                if ($cita->google_event_id !== $eventId) {
                    $cita->google_event_id = $eventId;
                    $cita->save();
                }
                $n++;
            } catch (\Throwable $e) {
                // Opcional: deja un log para depurar si una cita concreta falla
                Log::warning('Fallo al sincronizar cita con Google', [
                    'cita'   => $cita->id_cita,
                    'perfil' => $perfilId,
                    'msg'    => $e->getMessage(),
                ]);

                // continúa con las demás
                continue;
            }
        }
        return $n;
    }

    private function eventMissingInGoogle(\Google\Service\Exception $e): bool
    {
        // Códigos típicos cuando el evento fue borrado o no existe
        if (in_array($e->getCode(), [404, 410], true)) {
            return true;
        }
        // A veces viene como error con 'reason' => 'notFound' / 'gone'
        $errors = $e->getErrors();
        if (is_array($errors)) {
            foreach ($errors as $err) {
                $reason = $err['reason'] ?? '';
                if (in_array($reason, ['notFound', 'gone', 'deleted'], true)) {
                    return true;
                }
            }
        }
        return false;
    }


    // ====== Acciones ======

    public function connect(Request $request)
    {
        $this->ensurePremium($request);
        $force = (bool) session()->pull('force_select_account', false);
        return redirect()->away($this->googleClient($force)->createAuthUrl());
    }


    public function reconnect(Request $request)
    {
        $this->ensurePremium($request);

        $perfilId = (int) $request->input('perfil_id', (int) session('perfil_activo_id'));
        session([
            'google_sync_perfil_id' => $perfilId,   // al volver, sincronizamos ese perfil
            'force_select_account'  => true,        // bandera para select_account
        ]);

        // Revoca y limpia tokens
        $user = $request->user();
        $tokens = is_array($user->google_oauth_tokens)
            ? $user->google_oauth_tokens
            : (json_decode((string)$user->google_oauth_tokens, true) ?: []);

        try {
            $client = $this->googleClient(true);
            if (!empty($tokens['access_token']))  $client->revokeToken($tokens['access_token']);
            if (!empty($tokens['refresh_token'])) $client->revokeToken($tokens['refresh_token']);
        } catch (\Throwable $e) {
            // ignoramos errores de revocación
        }

        $user->google_oauth_tokens = null;
        $user->save();

        // Redirige a Google con select_account
        return redirect()->away($this->googleClient(true)->createAuthUrl());
    }


    public function callback(Request $request)
    {
        $this->ensurePremium($request);

        // Si viene error desde Google (p.ej., access_denied)
        if ($request->filled('error')) {
            return redirect()->route('cita.index')->with('error', 'Permiso denegado en Google: ' . $request->string('error'));
        }

        if ($request->has('code')) {
            try {
                $client = $this->googleClient();
                $tokens = $client->fetchAccessTokenWithAuthCode($request->string('code'));

                if (isset($tokens['error'])) {
                    return redirect()->route('cita.index')->with('error', 'No se pudo obtener el token: ' . $tokens['error']);
                }

                $u = $request->user();
                // Asegura que guardamos el refresh_token si está presente
                $u->google_oauth_tokens = $tokens;
                $u->save();

                // Si veníamos de "Sincronizar", termina el trabajo automáticamente.
                if (session()->has('google_sync_perfil_id')) {
                    $perfilId = (int) session()->pull('google_sync_perfil_id');
                    session()->forget('force_select_account');
                    if ($perfilId > 0 && $this->userOwnsPerfil($request, $perfilId)) {
                        try {
                            $n = $this->syncPerfil($request, $perfilId);
                            return redirect()->route('cita.index')->with('success', "Google conectado. Sincronizadas {$n} citas.");
                        } catch (\Throwable $e) {
                            return redirect()->route('cita.index')->with('error', 'Autorizado, pero falló la sincronización: ' . $e->getMessage());
                        }
                    }
                }

                return redirect()->route('cita.index')->with('success', 'Google conectado.');
            } catch (\Throwable $e) {
                return redirect()->route('cita.index')->with('error', 'Error en el callback de Google: ' . $e->getMessage());
            }
        }

        return redirect()->route('cita.index')->with('error', 'No se pudo autorizar Google.');
    }

    /** Botón lateral: sincroniza SOLO las citas del PERFIL ACTIVO (las que ves en la tabla). */
    public function syncAll(Request $request)
    {
        $this->ensurePremium($request);

        // Tomamos el perfil activo del hidden; si no llega, usamos el de sesión.
        $perfilId = (int) $request->input('perfil_id', (int) session('perfil_activo_id'));

        if ($perfilId <= 0) {
            return back()->with('error', 'No se pudo determinar el perfil activo.');
        }

        // Si no hay tokens, iniciamos OAuth y, al volver, seguimos.
        if (empty($request->user()->google_oauth_tokens)) {
            session(['google_sync_perfil_id' => $perfilId]);
            return redirect()->away($this->googleClient()->createAuthUrl());
        }

        try {
            $n = $this->syncPerfil($request, $perfilId);
            return back()->with('success', "Sincronizadas {$n} citas con Google Calendar.");
        } catch (\Throwable $e) {
            return back()->with('error', 'No se pudieron sincronizar las citas: ' . $e->getMessage());
        }
    }
}
