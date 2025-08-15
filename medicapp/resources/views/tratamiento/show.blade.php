@extends('layouts.auth')

@section('title', 'Detalles de tratamiento – MedicApp')

@section('content')
<div class="flex flex-col px-10 pt-6 h-full">
    <!-- Título -->
    <h2 class="text-3xl font-bold mb-8 text-center">
        Tratamiento para {{ $tratamiento->causa }}
    </h2>

    <!-- Botón añadir medicación -->
    <div class="flex justify-center mb-6">
        <a href="{{ route('medicacion.create', $tratamiento->id_tratamiento) }}"
           class="bg-green-400 hover:bg-green-500 text-[#0C1222] font-semibold px-6 py-3 rounded-full shadow transition">
            Añadir medicación
        </a>
    </div>

    @php
        $activas = $tratamiento->medicaciones->where('estado', 'activo');
        $archivadas = $tratamiento->medicaciones->where('estado', 'archivado');
    @endphp

    {{-- MEDICACIONES ACTIVAS --}}
    @foreach ($activas as $medicacion)
        <div class="mb-12">
            <h3 class="text-2xl font-semibold text-white mb-4">{{ $medicacion->medicamento->nombre ?? '(Sin nombre)' }}</h3>

            <table class="w-full text-sm text-white border border-white mb-4">
                <thead class="bg-white text-black uppercase text-center">
                    <tr>
                        <th class="py-3 px-4">Indicación</th>
                        <th class="py-3 px-4">Presentación</th>
                        <th class="py-3 px-4">Vía</th>
                        <th class="py-3 px-4">Dosis</th>
                        <th class="py-3 px-4">Pauta</th>
                        <th class="py-3 px-4">Observaciones</th>
                        <th class="py-3 px-4">Estado</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr class="border-t border-white">
                        <td class="py-3">{{ $medicacion->indicacion }}</td>
                        <td class="py-3">{{ $medicacion->presentacion }}</td>
                        <td class="py-3">{{ $medicacion->via }}</td>
                        <td class="py-3">{{ $medicacion->dosis }}</td>
                        <td class="py-3">cada {{ $medicacion->pauta_intervalo }} {{ $medicacion->pauta_unidad }}</td>
                        <td class="py-3">{{ $medicacion->observaciones ?? '—' }}</td>
                        <td class="py-3 capitalize">{{ $medicacion->estado ?? 'activo' }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="flex gap-6 justify-start">
                <a href="{{ route('medicacion.edit', $medicacion->id_trat_med) }}"
                   class="bg-yellow-200 hover:bg-yellow-300 text-[#0C1222] font-bold py-2 px-6 rounded-full shadow">
                    Modificar
                </a>
                <a href="{{ route('medicacion.replace.form', [$tratamiento->id_tratamiento, $medicacion->id_trat_med]) }}"
                   class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-full shadow">
                    Sustituir
                </a>
                <form method="POST" action="{{ route('medicacion.archivar', $medicacion->id_trat_med) }}">
                    @csrf
                    @method('PUT')
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded-full shadow">
                        Archivar
                    </button>
                </form>
            </div>
        </div>
    @endforeach

    {{-- TABLA DE SUSTITUCIONES --}}
    @php
        $sustituciones = $tratamiento->medicaciones()
            ->conSustitucion()
            ->with(['medicamento','sustituidoPor.medicamento'])
            ->orderByDesc('updated_at')
            ->get();
    @endphp

    @if($sustituciones->isNotEmpty())
        <h3 class="text-2xl font-semibold text-white mb-4">Sustituciones</h3>

        <table class="w-full text-sm text-white border border-white mb-8">
            <thead class="bg-blue-400 text-black uppercase text-center">
                <tr>
                    <th class="py-3 px-4">Fecha</th>
                    <th class="py-3 px-4">Indicación</th>
                    <th class="py-3 px-4">Anterior</th>
                    <th class="py-3 px-4">Sustituto</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach($sustituciones as $antigua)
                    @php $nueva = $antigua->sustituidoPor; @endphp
                    @if($nueva)
                        <tr class="border-t border-white">
                            <td class="py-3">{{ $antigua->updated_at?->format('d/m/Y H:i') }}</td>
                            <td class="py-3">{{ $antigua->indicacion }}</td>
                            <td class="py-3">
                                {{ $antigua->medicamento->nombre ?? '(N/A)' }} — {{ $antigua->dosis }}
                                ({{ $antigua->pauta_intervalo }} {{ $antigua->pauta_unidad }})
                            </td>
                            <td class="py-3">
                                {{ $nueva->medicamento->nombre ?? '(N/A)' }} — {{ $nueva->dosis }}
                                ({{ $nueva->pauta_intervalo }} {{ $nueva->pauta_unidad }})
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- MEDICACIONES ARCHIVADAS - UNA SOLA TABLA --}}
    @if($archivadas->isNotEmpty())
        <h3 class="text-2xl font-semibold text-white mt-2 mb-4">Medicaciones archivadas</h3>

        <div class="overflow-x-auto mb-12">
            <table class="w-full text-sm text-white border border-white">
                <thead class="bg-gray-400 text-black uppercase text-center">
                    <tr>
                        <th class="py-3 px-4">Indicación</th>
                        <th class="py-3 px-4">Medicamento</th>
                        <th class="py-3 px-4">Presentación</th>
                        <th class="py-3 px-4">Vía</th>
                        <th class="py-3 px-4">Dosis</th>
                        <th class="py-3 px-4">Pauta</th>
                        <th class="py-3 px-4">Observaciones</th>
                        <th class="py-3 px-4">Estado</th> 
                        <th class="py-3 px-4 w-16">Eliminar</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($archivadas as $med)
                        @php $fueSustituida = !is_null($med->sustituido_por); @endphp
                        <tr class="border-t border-white">
                            <td class="py-3 px-4">{{ $med->indicacion }}</td>
                            <td class="py-3 px-4">
                                {{ $med->medicamento->nombre ?? '(Sin nombre)' }}
                            </td>
                            <td class="py-3 px-4">{{ $med->presentacion }}</td>
                            <td class="py-3 px-4">{{ $med->via }}</td>
                            <td class="py-3 px-4">{{ $med->dosis }}</td>
                            <td class="py-3 px-4">cada {{ $med->pauta_intervalo }} {{ $med->pauta_unidad }}</td>
                            <td class="py-3 px-4">{{ $med->observaciones ?? '—' }}</td>

                            {{-- Indicador visual de "Sustituida" / "Archivada" --}}
                            <td class="py-3 px-4">
                                @if($fueSustituida)
                                    <span class="inline-block px-2 py-1">
                                        Sustituida
                                    </span>
                                @else
                                    <span class="inline-block px-2 py-1">
                                        Archivada
                                    </span>
                                @endif
                            </td>

                            {{-- Acciones: eliminar activo/deshabilitado --}}
                            <td class="py-3 px-4 text-center align-middle">
                                @if($fueSustituida)
                                    <button type="button"
                                            class="bg-gray-400 text-white p-2 rounded-full shadow inline-flex items-center justify-center cursor-not-allowed opacity-70"
                                            title="No se puede eliminar: medicación sustituida"
                                            aria-disabled="true" disabled>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-1 1v1H4a1 1 0 000 2h12a1 1 0 100-2h-4V3a1 1 0 00-1-1H9zM5 7a1 1 0 011-1h8a1 1 0 011 1v9a2 2 0 01-2 2H7a2 2 0 01-2-2V7zm3 1a1 1 0 10-2 0v8a1 1 0 102 0V8zm4 0a1 1 0 10-2 0v8a1 1 0 102 0V8z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                @else
                                    <form method="POST"
                                        action="{{ route('medicacion.destroy', $med->id_trat_med) }}"
                                        onsubmit="return confirm('¿Eliminar definitivamente esta medicación archivada?');"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-full shadow inline-flex items-center justify-center"
                                                title="Eliminar">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-1 1v1H4a1 1 0 000 2h12a1 1 0 100-2h-4V3a1 1 0 00-1-1H9zM5 7a1 1 0 011-1h8a1 1 0 011 1v9a2 2 0 01-2 2H7a2 2 0 01-2-2V7zm3 1a1 1 0 10-2 0v8a1 1 0 102 0V8zm4 0a1 1 0 10-2 0v8a1 1 0 102 0V8z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    
</div>
@endsection
