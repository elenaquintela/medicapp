@extends('layouts.auth')

@section('title', 'Informes – MedicApp')

@section('content')
<div class="px-10 py-8">
    <h2 class="text-3xl font-bold text-center mb-8">Informes</h2>

    {{-- Formulario generar informe --}}
    <div class="bg-[#0C1222] border border-gray-500 rounded-xl p-6 text-white max-w-3xl mx-auto mb-10">
        <h3 class="text-yellow-200 font-bold text-xl mb-4">Generar informe</h3>

        <form method="POST" action="{{ route('informe.store') }}" class="grid gap-4 grid-cols-1 md:grid-cols-3 items-end">
            @csrf
            <div class="md:col-span-3">
                <label class="block mb-1">Tratamiento del perfil activo ({{ $perfil->nombre_paciente }})</label>
                <select name="id_tratamiento" id="id_tratamiento" class="w-full px-3 py-2 rounded text-black" required>
                    <option value="" disabled selected>Selecciona un tratamiento</option>
                    @foreach ($tratamientos as $t)
                        <option
                            value="{{ $t->id_tratamiento }}"
                            data-inicio="{{ \Illuminate\Support\Carbon::parse($t->fecha_inicio)->toDateString() }}"
                            @selected(old('id_tratamiento') == $t->id_tratamiento)
                        >
                            {{ $t->causa }}
                        </option>
                    @endforeach
                </select>


                @error('id_tratamiento') <p class="text-red-400 mt-1 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Desde</label>
                <input type="date" name="rango_inicio" id="rango_inicio"
                value="{{ old('rango_inicio', $defInicio) }}"
                class="w-full px-3 py-2 rounded text-black" required>

            </div>
            <div>
                <label class="block mb-1">Hasta</label>
                <input type="date" name="rango_fin" value="{{ $defFin }}" class="w-full px-3 py-2 rounded text-black" required>
            </div>

            <div class="md:col-span-3">
                <button type="submit" class="bg-green-400 hover:bg-green-500 text-black font-bold py-2 px-6 rounded-full">
                    Generar PDF
                </button>
            </div>
        </form>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const select = document.getElementById('id_tratamiento');
            const desde  = document.getElementById('rango_inicio');

            function setDesdeFromSelected() {
                const opt = select.options[select.selectedIndex];
                const inicio = opt?.dataset?.inicio;
                if (inicio) desde.value = inicio; // formato YYYY-MM-DD
            }

            // Cuando el usuario elige un tratamiento
            select.addEventListener('change', setDesdeFromSelected);

            // Si ya viene seleccionado por old(...) al volver de validación, ajusta también
            if (select.value) setDesdeFromSelected();
        });
        </script>

    </div>

    {{-- Listado de informes --}}
    <div class="bg-[#0C1222] border border-gray-500 rounded-xl p-6 text-white max-w-5xl mx-auto">
        <h3 class="text-yellow-200 font-bold text-xl mb-4">Histórico de informes</h3>

        @if(session('success')) <p class="text-green-400 mb-3">{{ session('success') }}</p> @endif

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-600 text-sm">
                <thead class="bg-blue-200 text-[#0C1222]">
                    <tr>
                        <th class="px-3 py-2 text-left">Fecha</th>
                        <th class="px-3 py-2 text-left">Tratamiento</th>
                        <th class="px-3 py-2 text-left">Rango</th>
                        <th class="px-3 py-2 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($informes as $inf)
                        <tr class="border-t border-gray-600">
                            <td class="px-3 py-2">{{ \Illuminate\Support\Carbon::parse($inf->ts_creacion)->format('d/m/Y H:i') }}</td>
                            <td class="px-3 py-2">
                                @if($inf->tratamiento)
                                    #{{ $inf->tratamiento->id_tratamiento }} — {{ $inf->tratamiento->causa }}
                                @else
                                    <em>Tratamiento eliminado</em>
                                @endif
                            </td>
                            <td class="px-3 py-2">
                                {{ \Illuminate\Support\Carbon::parse($inf->rango_inicio)->format('d/m/Y') }}
                                —
                                {{ \Illuminate\Support\Carbon::parse($inf->rango_fin)->format('d/m/Y') }}
                            </td>
                            <td class="px-3 py-2">
                                <div class="flex gap-2">
                                    <a href="{{ route('informe.download', $inf->id_informe) }}"
                                       class="px-3 py-1 rounded-full bg-yellow-300 hover:bg-yellow-200 text-[#0C1222] font-semibold">
                                        Descargar
                                    </a>
                                    <form method="POST" action="{{ route('informe.destroy', $inf->id_informe) }}"
                                          onsubmit="return confirm('¿Eliminar este informe?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-3 py-1 rounded-full bg-red-600 hover:bg-red-700 text-white font-semibold">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="border-t border-gray-600">
                            <td class="px-3 py-3 text-gray-300" colspan="4">Aún no has generado informes.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
