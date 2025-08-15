@extends('layouts.auth')

@section('title', 'Nueva cita – MedicApp')

@section('content')
<div class="px-10 pt-6 h-full">

    <h2 class="text-3xl font-bold mb-10 text-center">Nueva cita</h2>

    <form action="{{ route('cita.store') }}" method="POST"
          class="mx-auto w-[75%] grid grid-cols-1 md:grid-cols-2 gap-10 items-start">
        @csrf

        <div class="flex flex-col gap-6">
            <div class="flex items-center gap-4">
                <label class="w-24 text-white">Fecha</label>
                <input type="date" name="fecha" required
                    class="p-3 rounded-md text-black text-sm" />
            </div>

            <div class="flex items-center gap-4">
                <label class="w-32 text-white">Hora</label>
                <div class="flex gap-3 w-full">
                    <input type="time" name="hora_inicio" required
                        class="p-2 rounded-md text-black text-sm w-[90px]">
                    <span class="text-white">-</span>
                    <input type="time" name="hora_fin"
                        class="p-2 rounded-md text-black text-sm w-[90px]">
                </div>
            </div>
            <div class="flex items-center gap-4">
                <label class="w-32 text-white">Lugar</label>
                <input type="text" name="ubicacion" required
                    class="w-full p-3 rounded-md text-black text-sm"
                    placeholder="Centro de salud de Fontiñas">
            </div>
            <div class="flex items-center gap-4">
                <label class="w-32 text-white">Motivo</label>
                <input type="text" name="motivo" required
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
                            <option value="{{ $esp }}">{{ $esp }}</option>
                        @endforeach
                        <option value="otra">Otra</option>
                    </select>
    
                    <input type="text" name="especialidad_otra" id="input-especialidad-otra"
                        class="w-full mt-2 p-3 rounded-md text-black text-sm hidden"
                        placeholder="Especifique la especialidad" />
                </div>
            </div>

            <div class="flex flex-col gap-2">
                <label class="text-white">Observaciones</label>
                <textarea name="observaciones" rows="6"
                    class="w-full p-3 rounded-md text-black text-sm resize-none"
                    placeholder="Añade información adicional si es necesario..."></textarea>
            </div>
        </div>

        <div class="md:col-span-2 flex justify-center mt-6">
            <button type="submit"
                class="bg-yellow-200 hover:bg-yellow-300 text-black font-bold py-3 px-10 rounded-full text-lg shadow-md">
                Crear cita
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
