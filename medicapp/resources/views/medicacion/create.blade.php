@extends('layouts.registro')

@section('content')
<main class="flex-grow px-4 py-10 flex justify-center">
    <div class="w-full max-w-3xl pb-32">
        <h2 class="text-3xl font-bold text-center mb-10">
            Medicación para {{ $tratamiento->causa }}
        </h2>

        <form method="POST"
              action="{{ isset($medicacion) ? route('medicacion.update', $medicacion->id_trat_med) : route('medicacion.store', $tratamiento->id_tratamiento) }}"
              class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @csrf
            @if (isset($medicacion))
                @method('PUT')
            @endif

            @if (request('volver_a_index'))
                <input type="hidden" name="volver_a_index" value="1">
            @endif

            {{-- Columna izquierda --}}
            <div class="space-y-4">
                <label class="block">
                    <span class="text-lg">Nombre</span>
                    <input name="nombre" type="text" required
                           value="{{ old('nombre', $medicacion->medicamento->nombre ?? '') }}"
                           class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222]">
                </label>

                <label class="block">
                    <span class="text-lg">Indicación</span>
                    <input name="indicacion" type="text" required
                           value="{{ old('indicacion', $medicacion->indicacion ?? '') }}"
                           class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222]">
                </label>

                <label class="block">
                    <span class="text-lg">Presentación</span>
                    <select name="presentacion" required
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222] bg-white">
                        @foreach (['comprimidos','jarabe','gotas','inyeccion','pomada','parche','polvo','spray','otro'] as $op)
                            <option value="{{ $op }}" @if(old('presentacion', $medicacion->presentacion ?? '') === $op) selected @endif>
                                {{ ucfirst($op) }}
                            </option>
                        @endforeach
                    </select>
                </label>
            </div>

            {{-- Columna derecha --}}
            <div class="space-y-4">
                <label class="block">
                    <span class="text-lg">Vía</span>
                    <select name="via" required
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222] bg-white">
                        @foreach (['oral','topica','nasal','ocular','otica','intravenosa','intramuscular','subcutanea','rectal','inhalatoria','otro'] as $op)
                            <option value="{{ $op }}" @if(old('via', $medicacion->via ?? '') === $op) selected @endif>
                                {{ ucfirst($op) }}
                            </option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="text-lg">Dosis</span>
                    <input name="dosis" type="text" required
                           value="{{ old('dosis', $medicacion->dosis ?? '') }}"
                           class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222]">
                </label>

                <label class="block">
                    <span class="text-lg">Inicio</span>
                    <input name="fecha_hora_inicio" type="datetime-local" required
                           value="{{ old('fecha_hora_inicio', isset($medicacion) ? \Carbon\Carbon::parse($medicacion->fecha_hora_inicio)->format('Y-m-d\TH:i') : '') }}"
                           class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222]">
                </label>
            </div>

            {{-- Pauta y observaciones --}}
            <div class="col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                <label class="block">
                    <span class="text-lg">Cada cuántos</span>
                    <input name="pauta_intervalo" type="number" required min="1"
                           value="{{ old('pauta_intervalo', $medicacion->pauta_intervalo ?? '') }}"
                           class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222]">
                </label>

                <label class="block">
                    <span class="text-lg">Unidad de tiempo</span>
                    <select name="pauta_unidad" required
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222] bg-white">
                        @foreach (['horas','dias','semanas','meses'] as $unidad)
                            <option value="{{ $unidad }}" @if(old('pauta_unidad', $medicacion->pauta_unidad ?? '') === $unidad) selected @endif>
                                {{ ucfirst($unidad) }}
                            </option>
                        @endforeach
                    </select>
                </label>

                <label class="block col-span-2">
                    <span class="text-lg">Observaciones</span>
                    <textarea name="observaciones" rows="3"
                              class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222]">{{ old('observaciones', $medicacion->observaciones ?? '') }}</textarea>
                </label>
            </div>

            <div class="col-span-2 mt-8 text-center">
                <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-full shadow transition">
                    {{ isset($medicacion) ? 'Actualizar medicación' : 'Guardar medicación' }}
                </button>
            </div>
        </form>
    </div>
</main>
@endsection
