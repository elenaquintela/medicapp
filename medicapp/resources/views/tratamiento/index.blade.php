@extends('layouts.auth')

@section('title', 'Tratamientos – MedicApp')

@section('content')
@php
    $rol = Auth::user()->rol_global;
@endphp

<div class="flex flex-col px-10 pt-6 h-full">

    <!-- Título centrado -->
    <h2 class="text-3xl font-bold mb-8 text-center">Tratamientos</h2>

    <!-- Filtro -->
    <div class="flex items-center gap-3 mb-6 w-full max-w-[85%]">
        <img src="{{ asset('filtro.png') }}" alt="Filtro"
             class="h-12 aspect-auto object-contain brightness-0 invert" />

        <input type="text"
               class="w-full p-3 rounded-md text-black placeholder-gray-600 text-sm"
               placeholder="Filtre por causa, estado, fecha o creador" />
    </div>

    <!-- Contenedor tabla + botones -->
    <div class="flex w-full items-start">

        <!-- Tabla de tratamientos -->
        <div class="max-w-[85%] w-full overflow-x-auto mx-auto">
            <table class="w-full text-sm text-white border border-white">
                <thead class="bg-blue-400 text-black uppercase text-center">
                    <tr>
                        <th class="py-3 px-4">Causa</th>
                        <th class="py-3 px-4">Estado</th>
                        <th class="py-3 px-4">Fecha de inicio</th>
                        <th class="py-3 px-4">Creado por</th>
                        <th class="py-3 px-4">Ver detalles</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse ($tratamientos as $tratamiento)
                        <tr class="border-t border-white">
                            <td class="py-3">{{ $tratamiento->causa }}</td>
                            <td class="py-3">{{ ucfirst($tratamiento->estado) }}</td>
                            <td class="py-3">{{ \Carbon\Carbon::parse($tratamiento->fecha_inicio)->format('d / m / Y') }}</td>
                            <td class="py-3 font-semibold">
                                {{ $tratamiento->usuarioCreador->nombre ?? 'Desconocido' }}
                            </td>

                            <td class="py-3">
                                <a href="{{ route('tratamiento.show', $tratamiento->id_tratamiento) }}" class="hover:opacity-80 inline-block">
                                    <img src="{{ asset('detalles.png') }}" alt="Detalles" class="w-6 h-6 object-contain invert mx-auto">
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-gray-300">No hay tratamientos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Botón añadir tratamiento -->
        <div class="w-[15%] flex flex-col items-center justify-center gap-6">
            <a href="{{ route('tratamiento.create', ['volver_a_index' => 1]) }}"
               class="bg-green-400 hover:bg-green-500 text-black rounded-full w-20 h-20 flex items-center justify-center shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" />
                </svg>
            </a>
        </div>

    </div>
</div>
@endsection
