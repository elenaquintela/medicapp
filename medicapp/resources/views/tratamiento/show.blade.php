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

    @foreach ($tratamiento->medicaciones as $medicacion)
        <div class="mb-12">
            <!-- Nombre del medicamento -->
            <h3 class="text-2xl font-semibold text-white mb-4">{{ $medicacion->medicamento->nombre ?? '(Sin nombre)' }}</h3>

            <!-- Tabla -->
            <table class="w-full text-sm text-white border border-white mb-4">
                <thead class="bg-blue-400 text-black uppercase text-center">
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

            <!-- Botones -->
            <div class="flex gap-6 justify-start">
                <a href="#" class="bg-yellow-200 hover:bg-yellow-300 text-[#0C1222] font-bold py-2 px-6 rounded-full shadow">Modificar</a>
                <a href="#" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded-full shadow">Archivar</a>
                <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-full shadow">Sustituir</a>
            </div>
        </div>
    @endforeach
</div>
@endsection
