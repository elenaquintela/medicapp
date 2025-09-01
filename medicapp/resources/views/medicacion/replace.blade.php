@extends('layouts.auth')

@section('title', 'Sustituir medicación – MedicApp')

@section('content')
<main class="flex-grow px-4 py-10 flex justify-center">
    <div class="w-full max-w-sm sm:max-w-md lg:max-w-3xl pb-24">
        <h2 class="text-2xl sm:text-3xl font-bold text-center mb-8 sm:mb-10">
            Sustituir medicación ({{ $tratamiento->causa }})
        </h2>

        <div class="mb-8 p-4 border border-gray-300 rounded text-[#0C1222] bg-white/80 text-sm sm:text-base">
            <p class="mb-1"><strong>Indicación:</strong> {{ $original->indicacion }}</p>
            <p class="mb-1"><strong>Medicamento actual:</strong> {{ $original->medicamento->nombre }}</p>
            <p class="mb-0"><strong>Dosis actual:</strong> {{ $original->dosis }}</p>
        </div>

        <form method="POST"
              action="{{ route('medicacion.replace', [$tratamiento->id_tratamiento, $original->id_trat_med]) }}"
              class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
            @csrf

            {{-- Columna izquierda --}}
            <div class="space-y-4">
                <label class="block">
                    <span class="text-base sm:text-lg">Nombre</span>
                    <input name="nombre" type="text" required
                           value="{{ old('nombre') }}"
                           class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222]">
                </label>

                <label class="block">
                    <span class="text-base sm:text-lg">Presentación</span>
                    <select name="presentacion" required
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222] bg-white">
                        @foreach (['comprimidos','jarabe','gotas','inyeccion','pomada','parche','polvo','spray','otro'] as $op)
                            <option value="{{ $op }}" @selected(old('presentacion') === $op)>{{ ucfirst($op) }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="text-base sm:text-lg">Frecuencia (cada...)</span>
                    <input name="pauta_intervalo" type="number" required min="1"
                           value="{{ old('pauta_intervalo') }}"
                           class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222]">
                </label>

                <label class="block">
                    <span class="text-base sm:text-lg">Inicio</span>
                    <input name="fecha_hora_inicio" type="datetime-local"
                           value="{{ old('fecha_hora_inicio') }}"
                           class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222]">
                </label>
            </div>

            {{-- Columna derecha --}}
            <div class="space-y-4">
                <label class="block">
                    <span class="text-base sm:text-lg">Vía</span>
                    <select name="via" required
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222] bg-white">
                        @foreach (['oral','topica','nasal','ocular','otica','intravenosa','intramuscular','subcutanea','rectal','inhalatoria','otro'] as $op)
                            <option value="{{ $op }}" @selected(old('via') === $op)>{{ ucfirst($op) }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="text-base sm:text-lg">Dosis</span>
                    <input name="dosis" type="text" required placeholder="1g, 50mg ..."
                           value="{{ old('dosis') }}"
                           class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222]">
                </label>

                <label class="block">
                    <span class="text-base sm:text-lg">Unidad de tiempo</span>
                    <select name="pauta_unidad" required
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222] bg-white">
                        @foreach (['horas','dias','semanas','meses'] as $unidad)
                            <option value="{{ $unidad }}" @selected(old('pauta_unidad') === $unidad)>{{ ucfirst($unidad) }}</option>
                        @endforeach
                    </select>
                </label>
            </div>

            {{-- Observaciones full width --}}
            <label class="block col-span-1 md:col-span-2">
                <span class="text-base sm:text-lg">Observaciones</span>
                <textarea name="observaciones" rows="3"
                          class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222]">{{ old('observaciones') }}</textarea>
            </label>

            {{-- Botonera responsive: columna en móvil, fila en escritorio --}}
            <div class="col-span-1 md:col-span-2 mt-6 sm:mt-8 flex flex-col sm:flex-row sm:flex-wrap gap-3 sm:gap-4 justify-center items-stretch">
                <a href="{{ route('tratamiento.show', $tratamiento->id_tratamiento) }}"
                   class="w-full sm:w-auto text-center bg-gray-300 hover:bg-gray-400 text-black font-semibold py-3 px-8 rounded-full shadow transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="w-full sm:w-auto bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-8 rounded-full shadow transition">
                    Sustituir
                </button>
            </div>
        </form>
    </div>
</main>
@endsection
