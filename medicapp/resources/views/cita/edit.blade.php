@extends('layouts.auth')

@section('title', 'Editar cita – MedicApp')

@section('content')
<div class="px-10 pt-6 h-full">

    <!-- Título centrado -->
    <h2 class="text-3xl font-bold mb-10 text-center">Editar cita</h2>

    <form method="POST" action="{{ route('cita.update', $cita->id_cita) }}"
          class="mx-auto w-[75%] grid grid-cols-1 md:grid-cols-2 gap-10 items-start">
        @csrf
        @method('PUT')

        <!-- Columna izquierda -->
        <div class="flex flex-col gap-6">
            <!-- Fecha -->
            <div class="flex items-center gap-4">
                <label class="w-24 text-white">Fecha</label>
                <input type="date" name="fecha" required
                       value="{{ old('fecha', $cita->fecha) }}"
                       class="p-3 rounded-md text-black text-sm" />
            </div>

            <!-- Hora -->
            <div class="flex items-center gap-4">
                <label class="w-32 text-white">Hora</label>
                <div class="flex gap-3 w-full">
                    <input type="time" name="hora_inicio" required
                           value="{{ old('hora_inicio', $cita->hora_inicio) }}"
                           class="p-2 rounded-md text-black text-sm w-[90px]">
                    <span class="text-white">-</span>
                    <input type="time" name="hora_fin"
                           value="{{ old('hora_fin', $cita->hora_fin) }}"
                           class="p-2 rounded-md text-black text-sm w-[90px]">
                </div>
            </div>

            <!-- Lugar -->
            <div class="flex items-center gap-4">
                <label class="w-32 text-white">Lugar</label>
                <input type="text" name="ubicacion" required maxlength="120"
                       value="{{ old('ubicacion', $cita->ubicacion) }}"
                       class="w-full p-3 rounded-md text-black text-sm"
                       placeholder="Centro de salud de Fontiñas">
            </div>

            <!-- Motivo -->
            <div class="flex items-center gap-4">
                <label class="w-32 text-white">Motivo</label>
                <input type="text" name="motivo" required maxlength="150"
                       value="{{ old('motivo', $cita->motivo) }}"
                       class="w-full p-3 rounded-md text-black text-sm"
                       placeholder="Renovación de Alta">
            </div>
        </div>

        <!-- Columna derecha -->
        <div class="flex flex-col gap-6">
            <!-- Especialidad -->
            <div class="flex items-center gap-4">
                <label for="especialidad" class="w-32 text-white">Especialidad</label>
                <div class="w-full">
                    <select name="especialidad" id="especialidad"
                            class="w-full p-3 rounded-md text-black text-sm"
                            onchange="mostrarInputEspecialidad(this)">
                        <option value="">Seleccione una especialidad</option>
                        @foreach ($especialidades as $esp)
                            <option value="{{ $esp }}" {{ old('especialidad', $cita->especialidad) === $esp ? 'selected' : '' }}>
                                {{ $esp }}
                            </option>
                        @endforeach
                        <option value="otra" {{ !in_array(old('especialidad', $cita->especialidad), $especialidades) ? 'selected' : '' }}>
                            Otra
                        </option>
                    </select>

                    <input type="text" name="especialidad_otra" id="input-especialidad-otra"
                           class="w-full mt-2 p-3 rounded-md text-black text-sm {{ in_array(old('especialidad', $cita->especialidad), $especialidades) ? 'hidden' : '' }}"
                           placeholder="Especifique la especialidad"
                           value="{{ !in_array(old('especialidad', $cita->especialidad), $especialidades) ? old('especialidad', $cita->especialidad) : '' }}">
                </div>
            </div>

            <!-- Observaciones -->
            <div class="flex flex-col gap-2">
                <label class="text-white">Observaciones</label>
                <textarea name="observaciones" rows="6"
                          class="w-full p-3 rounded-md text-black text-sm resize-none"
                          placeholder="Añade información adicional si es necesario...">{{ old('observaciones', $cita->observaciones) }}</textarea>
            </div>
        </div>

        <!-- Botón Guardar -->
        <div class="md:col-span-2 flex justify-center mt-6">
            <button type="submit"
                    class="bg-yellow-200 hover:bg-yellow-300 text-black font-bold py-3 px-10 rounded-full text-lg shadow-md">
                Guardar cambios
            </button>
        </div>
    </form>
</div>

<script>
function mostrarInputEspecialidad(select) {
    const input = document.getElementById('input-especialidad-otra');
    if (select.value === 'otra') {
        input.classList.remove('hidden');
    } else {
        input.classList.add('hidden');
    }
}
</script>
@endsection
