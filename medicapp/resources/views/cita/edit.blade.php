@extends('layouts.auth')

@section('title', 'Editar cita – MedicApp')

@section('content')
<div class="px-10 pt-6 h-full">
    <h2 class="text-3xl font-bold mb-10 text-center">Editar cita</h2>
    <form id="form-editar-cita" method="POST" action="{{ route('cita.update', $cita->id_cita) }}"
          class="mx-auto w-[75%] grid grid-cols-1 md:grid-cols-2 gap-10 items-start">
        @csrf
        @method('PUT')

        <div class="flex flex-col gap-6">
            <div class="flex items-center gap-4">
                <label class="w-24 text-white">Fecha</label>
                <input type="date" name="fecha" required
                       value="{{ old('fecha', $cita->fecha) }}"
                       class="p-3 rounded-md text-black text-sm" />
            </div>
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
            <div class="flex items-center gap-4">
                <label class="w-32 text-white">Lugar</label>
                <input type="text" name="ubicacion" required maxlength="120"
                       value="{{ old('ubicacion', $cita->ubicacion) }}"
                       class="w-full p-3 rounded-md text-black text-sm"
                       placeholder="Centro de salud de Fontiñas">
            </div>
            <div class="flex items-center gap-4">
                <label class="w-32 text-white">Motivo</label>
                <input type="text" name="motivo" required maxlength="150"
                       value="{{ old('motivo', $cita->motivo) }}"
                       class="w-full p-3 rounded-md text-black text-sm"
                       placeholder="Renovación de Alta">
            </div>
        </div>

        <div class="flex flex-col gap-6">
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
            <div class="flex flex-col gap-2">
                <label class="text-white">Observaciones</label>
                <textarea name="observaciones" rows="6"
                          class="w-full p-3 rounded-md text-black text-sm resize-none"
                          placeholder="Añade información adicional si es necesario...">{{ old('observaciones', $cita->observaciones) }}</textarea>
            </div>
        </div>

        <div class="md:col-span-2 flex items-center justify-center gap-x-8 mt-6">
            <form action="{{ route('cita.destroy', $cita->id_cita) }}" method="POST"
                  onsubmit="return confirm('¿Está seguro de que desea cancelar esta cita? Esta acción no se puede deshacer.');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-8 rounded-full text-lg shadow-md">
                    Cancelar cita
                </button>
            </form>
            <button type="submit" form="form-editar-cita"
                    class="bg-yellow-200 hover:bg-yellow-300 text-black font-bold py-3 px-8 rounded-full text-lg shadow-md">
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
