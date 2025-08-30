<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Tratamiento;

class TratamientoController extends Controller
{
    public function index()
    {
        try {
            // Verificar usuario autenticado
            $usuario = Auth::user();
            if (!$usuario) {
                return redirect()->route('login');
            }

            // Obtener perfil activo usando DB facade para evitar conflictos PDO
            $perfilActivo = DB::table('perfiles')
                ->where('id_usuario', $usuario->id_usuario)
                ->where('activo', 1)
                ->first();

            if (!$perfilActivo) {
                return view('tratamiento.index', [
                    'tratamientos' => collect([]),
                    'perfilActivo' => null
                ]);
            }

            // Obtener tratamientos usando DB facade
            $tratamientos = DB::table('tratamientos')
                ->where('id_perfil', $perfilActivo->id_perfil)
                ->orderBy('created_at', 'desc')
                ->get();

            return view('tratamiento.index', [
                'tratamientos' => $tratamientos,
                'perfilActivo' => $perfilActivo
            ]);

        } catch (\Exception $e) {
            // Log específico para Railway
            error_log('TratamientoController Error: ' . $e->getMessage());
            
            return view('tratamiento.index', [
                'tratamientos' => collect([]),
                'perfilActivo' => null,
                'error' => 'Error al cargar tratamientos'
            ]);
        }
    }

    public function create()
    {
        try {
            $usuario = Auth::user();
            if (!$usuario) {
                return redirect()->route('login');
            }

            // Usar DB facade para obtener perfil activo
            $perfilActivo = DB::table('perfiles')
                ->where('id_usuario', $usuario->id_usuario)
                ->where('activo', 1)
                ->first();

            if (!$perfilActivo) {
                return redirect()->route('dashboard')->withErrors(['perfil' => 'No hay perfil activo.']);
            }

            return view('tratamiento.create', [
                'perfilActivo' => $perfilActivo
            ]);

        } catch (\Exception $e) {
            error_log('TratamientoController Create Error: ' . $e->getMessage());
            return redirect()->route('dashboard')->withErrors(['error' => 'Error al cargar formulario']);
        }
    }

    public function store(Request $request)
    {
        try {
            $usuario = Auth::user();
            if (!$usuario) {
                return redirect()->route('login');
            }

            $perfilActivo = DB::table('perfiles')
                ->where('id_usuario', $usuario->id_usuario)
                ->where('activo', 1)
                ->first();

            if (!$perfilActivo) {
                return redirect()->route('dashboard')->withErrors(['perfil' => 'No hay perfil activo.']);
            }

            $request->validate([
                'causa' => [
                    'required',
                    'string',
                    'max:150',
                    function ($attribute, $value, $fail) use ($perfilActivo) {
                        $existe = DB::table('tratamientos')
                            ->where('id_perfil', $perfilActivo->id_perfil)
                            ->where('causa', $value)
                            ->exists();

                        if ($existe) {
                            $fail('Ya existe un tratamiento con esta causa.');
                        }
                    },
                ],
                'tipo_tratamiento' => 'nullable|in:medico,psicologico,quirurgico,fisioterapia,otro',
                'notas' => 'nullable|string|max:500',
            ]);

            // Insertar usando DB facade
            DB::table('tratamientos')->insert([
                'id_perfil' => $perfilActivo->id_perfil,
                'causa' => $request->causa,
                'tipo_tratamiento' => $request->tipo_tratamiento ?? 'medico',
                'notas' => $request->notas,
                'estado' => 'activo',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('tratamiento.index')->with('success', 'Tratamiento creado exitosamente.');

        } catch (\Exception $e) {
            error_log('TratamientoController Store Error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error al guardar tratamiento'])->withInput();
        }
    }

    public function show($id)
    {
        try {
            $tratamiento = DB::table('tratamientos')->where('id_tratamiento', $id)->first();
            
            if (!$tratamiento) {
                return redirect()->route('tratamiento.index')->withErrors(['error' => 'Tratamiento no encontrado']);
            }

            return view('tratamiento.show', compact('tratamiento'));

        } catch (\Exception $e) {
            error_log('TratamientoController Show Error: ' . $e->getMessage());
            return redirect()->route('tratamiento.index')->withErrors(['error' => 'Error al mostrar tratamiento']);
        }
    }

    public function archivar($id)
    {
        try {
            $usuario = Auth::user();
            if (!$usuario) {
                return redirect()->route('login');
            }

            $perfilActivo = DB::table('perfiles')
                ->where('id_usuario', $usuario->id_usuario)
                ->where('activo', 1)
                ->first();

            if (!$perfilActivo) {
                return back()->withErrors(['error' => 'No hay perfil activo']);
            }

            $tratamiento = DB::table('tratamientos')->where('id_tratamiento', $id)->first();
            
            if (!$tratamiento || $tratamiento->id_perfil != $perfilActivo->id_perfil) {
                return back()->withErrors(['error' => 'No tienes permiso para archivar este tratamiento']);
            }

            DB::table('tratamientos')
                ->where('id_tratamiento', $id)
                ->update([
                    'estado' => 'archivado',
                    'updated_at' => now()
                ]);

            return back()->with('success', 'Tratamiento archivado');

        } catch (\Exception $e) {
            error_log('TratamientoController Archivar Error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error al archivar tratamiento']);
        }
    }

    public function reactivar($id)
    {
        try {
            DB::table('tratamientos')
                ->where('id_tratamiento', $id)
                ->update([
                    'estado' => 'activo',
                    'updated_at' => now()
                ]);

            return redirect()->route('tratamiento.index')->with('success', 'Tratamiento reactivado correctamente');

        } catch (\Exception $e) {
            error_log('TratamientoController Reactivar Error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error al reactivar tratamiento']);
        }
    }

    public function destroy($id)
    {
        try {
            $usuario = Auth::user();
            if (!$usuario) {
                return redirect()->route('login');
            }

            $perfilActivo = DB::table('perfiles')
                ->where('id_usuario', $usuario->id_usuario)
                ->where('activo', 1)
                ->first();

            if (!$perfilActivo) {
                return back()->withErrors(['error' => 'No hay perfil activo']);
            }

            $tratamiento = DB::table('tratamientos')->where('id_tratamiento', $id)->first();
            
            if (!$tratamiento || $tratamiento->id_perfil != $perfilActivo->id_perfil) {
                return back()->withErrors(['error' => 'No tienes permiso para eliminar este tratamiento']);
            }

            if ($tratamiento->estado !== 'archivado') {
                return back()->withErrors(['error' => 'Solo puedes eliminar tratamientos archivados']);
            }

            DB::table('tratamientos')->where('id_tratamiento', $id)->delete();

            return back()->with('success', 'Tratamiento eliminado');

        } catch (\Exception $e) {
            error_log('TratamientoController Destroy Error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error al eliminar tratamiento']);
        }
    }
}
