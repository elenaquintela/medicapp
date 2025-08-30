@extends('layouts.auth')

@section('title', 'Perfiles – MedicApp')

@section('content')
<div class="flex flex-col items-center px-10 pt-10">
    <h2 class="text-3xl font-bold mb-2 text-center">Perfiles</h2>
    <p class="text-center text-white mb-10">Seleccione en el desplegable amarillo el perfil que desea gestionar</p>

    @if (!$perfilActivo)
        <div class="text-white">
            <p>No tienes perfiles activos.</p>
            <a href="{{ route('perfil.create', ['fromDashboard' => 1]) }}" class="underline text-yellow-300">
                Crear primer perfil
            </a>
        </div>
    @else
        @php
            $soyInvitado = Auth::user()->perfiles()
                ->wherePivot('rol_en_perfil', 'invitado')
                ->where('perfil.id_perfil', $perfilActivo->id_perfil)
                ->exists();
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-2 items-start gap-12 w-full max-w-6xl">
            <div class="space-y-6">
                <div class="bg-transparent border-2 border-gray-500 rounded-lg p-8 w-full text-white">
                    <h3 class="text-xl font-bold mb-6 text-center text-yellow-200">Datos del paciente</h3>

                    <form id="form-perfil" method="POST" action="{{ route('perfil.update', $perfilActivo->id_perfil) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label class="block mb-2" for="nombre_paciente">Nombre</label>
                            <input type="text" id="nombre_paciente" name="nombre_paciente"
                                class="w-full p-2 rounded text-black"
                                value="{{ old('nombre_paciente', $perfilActivo->nombre_paciente) }}" required>
                        </div>

                        <div class="mb-6">
                            <label class="block mb-2" for="fecha_nacimiento">Fecha de nacimiento</label>
                            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"
                                class="w-full p-2 rounded text-black"
                                value="{{ old('fecha_nacimiento', $perfilActivo->fecha_nacimiento) }}" required>
                        </div>

                        <div>
                            <label class="block mb-2" for="sexo">Género</label>
                            <select id="sexo" name="sexo" class="w-full p-2 rounded text-black" required>
                                <option value="F" @selected($perfilActivo->sexo === 'F')>Mujer</option>
                                <option value="M" @selected($perfilActivo->sexo === 'M')>Hombre</option>
                                <option value="NB" @selected($perfilActivo->sexo === 'NB')>No binario</option>
                                <option value="O" @selected($perfilActivo->sexo === 'O')>Otro</option>
                            </select>
                        </div>
                    </form>

                    <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                        <button form="form-perfil"
                                class="bg-green-500 hover:bg-green-600 text-black font-bold w-full sm:w-auto px-3 py-2 sm:px-6 sm:py-3 rounded-full shadow text-sm sm:text-base">
                            Guardar cambios
                        </button>

                        <form method="POST" action="{{ route('perfil.destroy', $perfilActivo->id_perfil) }}"
                            onsubmit="return confirm('¿Está seguro de que desea eliminar este perfil? Esta acción no se puede deshacer.');"
                            class="w-full sm:w-auto">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white font-bold w-full sm:w-auto px-3 py-2 sm:px-6 sm:py-3 rounded-full shadow text-sm sm:text-base">
                                Eliminar perfil
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @if($perfilActivo && (($esPremium && $esPropietario) || $soyInvitado))
                <div class="bg-[#0C1222] border border-gray-500 rounded-xl p-6 text-white">
                    <h3 class="text-yellow-200 font-bold text-xl mb-4">Accesos compartidos</h3>

                    <p class="mb-4">
                        Usuario creador:
                        <span class="text-gray-300 font-mono">{{ $creador?->email ?? Auth::user()->email }}</span>
                    </p>

                    @if(($esPremium && $esPropietario) && $pendientes->count())
                        <div class="mb-4">
                            <h4 class="font-semibold mb-2">Invitaciones pendientes</h4>
                            <ul class="list-disc ml-5 text-sm text-gray-300">
                                @foreach($pendientes as $p)
                                    <li>{{ $p->email }} @if($p->expires_at)(caduca: {{ $p->expires_at->format('d/m/Y') }})@endif</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="overflow-x-auto mb-6">
                        <table class="min-w-full border border-gray-600">
                            <thead class="bg-blue-200 text-[#0C1222]">
                                <tr>
                                    <th class="px-4 py-2 text-left">USUARIOS INVITADOS</th>
                                    <th class="px-4 py-2 text-left">QUITAR</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invitados as $inv)
                                    <tr class="border-t border-gray-600">
                                        <td class="px-4 py-3">{{ $inv->email }}</td>
                                        <td class="px-4 py-3">
                                            @if($esPremium && $esPropietario)
                                                <form method="POST" action="{{ route('perfil.miembros.destroy', [$perfilActivo->id_perfil, $inv->id_usuario]) }}"
                                                    onsubmit="return confirm('¿Quitar acceso a {{ $inv->email }}?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold px-4 py-2 rounded-full">✕</button>
                                                </form>
                                            @else
                                                <span class="text-gray-400">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="border-t border-gray-600">
                                        <td class="px-4 py-3 text-gray-300" colspan="2">Sin invitados.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($esPremium && $esPropietario)
                        <form method="POST" action="{{ route('perfil.invitaciones.store', $perfilActivo->id_perfil) }}" class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
                            @csrf
                            <input type="email" name="email" placeholder="correo@ejemplo.com" class="flex-1 px-4 py-2 rounded text-black" required>
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-black font-bold w-full sm:w-auto px-4 py-2 rounded-full">Invitar</button>
                        </form>

                        @error('email') <p class="text-red-400 mt-3">{{ $message }}</p> @enderror
                        @if (session('success')) <p class="text-green-400 mt-3">{{ session('success') }}</p> @endif
                    @endif
                </div>
            @endif
        </div>
    @endif
</div>
@endsection
