<x-layouts.authenticated :perfilesUsuario="$perfilesUsuario" :perfilActivo="$perfilActivo">
    <div class="px-10 pt-6 h-full">
        <h2 class="text-3xl font-bold mb-10 text-center">Editar cita</h2>

        <form method="POST" action="{{ route('cita.update', $cita->id_cita) }}"
              class="mx-auto w-[75%] grid grid-cols-1 md:grid-cols-2 gap-10 items-start">
            @csrf
            @method('PUT')

            <!-- Columna izquierda -->
            <div class="flex flex-col gap-6">
                <!-- Fecha -->
                <div>
                    <label for="fecha" class="block mb-1 text-lg text-white">Fecha</label>
                    <input id="fecha" name="fecha" type="date" required
                           value="{{ old('fecha', $cita->fecha) }}"
                           class="w-full px-4 py-3 rounded text-[#0C1222] text-sm">
                </div>

                <!-- Hora inicio y fin -->
                <div>
                    <label class="block mb-1 text-lg text-white">Hora</label>
                    <div class="flex gap-3 w-full">
                        <input type="time" name="hora_inicio" required
                               value="{{ old('hora_inicio', $cita->hora_inicio) }}"
                               class="p-2 rounded-md text-[#0C1222] text-sm w-[90px]">
                        <span class="text-white">-</span>
                        <input type="time" name="hora_fin"
                               value="{{ old('hora_fin', $cita->hora_fin) }}"
                               class="p-2 rounded-md text-[#0C1222] text-sm w-[90px]">
                    </div>
                </div>

                <!-- Lugar -->
                <div>
                    <label for="ubicacion" class="block mb-1 text-lg text-white">Lugar</label>
                    <input id="ubicacion" name="ubicacion" type="text" required maxlength="120"
                           value="{{ old('ubicacion', $cita->ubicacion) }}"
                           class="w-full px-4 py-3 rounded text-[#0C1222] text-sm">
                </div>

                <!-- Motivo -->
                <div>
                    <label for="motivo" class="block mb-1 text-lg text-white">Motivo</label>
                    <input id="motivo" name="motivo" type="text" required maxlength="150"
                           value="{{ old('motivo', $cita->motivo) }}"
                           class="w-full px-4 py-3 rounded text-[#0C1222] text-sm">
                </div>
            </div>

            <!-- Columna derecha -->
            <div class="flex flex-col gap-6">
                <!-- Especialidad -->
                <!-- Especialidad -->
<div>
    <label for="especialidad" class="block mb-1 text-lg text-white">Especialidad</label>
    <div class="w-full">
        <select name="especialidad" id="especialidad"
            class="w-full p-3 rounded text-[#0C1222] text-sm"
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
               class="w-full mt-2 p-3 rounded text-[#0C1222] text-sm {{ in_array(old('especialidad', $cita->especialidad), $especialidades) ? 'hidden' : '' }}"
               placeholder="Especifique la especialidad"
               value="{{ !in_array(old('especialidad', $cita->especialidad), $especialidades) ? old('especialidad', $cita->especialidad) : '' }}">
    </div>
</div>


                <!-- Observaciones -->
                <div>
                    <label for="observaciones" class="block mb-1 text-lg text-white">Observaciones</label>
                    <textarea id="observaciones" name="observaciones" rows="6"
                              class="w-full px-4 py-3 rounded text-[#0C1222] text-sm resize-none">{{ old('observaciones', $cita->observaciones) }}</textarea>
                </div>

                <!-- Recordatorio -->
                <div class="flex items-center gap-3 mt-3">
                    <input type="checkbox" id="recordatorio" name="recordatorio"
                           {{ old('recordatorio', $cita->recordatorio) ? 'checked' : '' }}
                           class="h-5 w-5 text-green-500 accent-green-500">
                    <label for="recordatorio" class="text-white text-lg">¿Enviar recordatorio?</label>
                </div>
            </div>

            <!-- Botón Guardar -->
            <div class="md:col-span-2 flex justify-center mt-6">
                <button type="submit"
                        class="bg-yellow-200 hover:bg-yellow-300 text-[#0C1222] font-bold py-3 px-10 rounded-full text-lg shadow-md">
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

</x-layouts.authenticated>
