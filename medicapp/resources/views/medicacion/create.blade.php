@extends('layouts.registro')

@section('content')
<main class="flex-grow px-4 py-10 flex justify-center">
    <div class="w-full max-w-3xl pb-32">
        <h2 class="text-3xl font-bold text-center mb-10">
            Medicación para {{ $tratamiento->causa }}
        </h2>

        <form method="POST" action="{{ route('medicacion.store', $tratamiento->id_tratamiento) }}" class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @csrf

            <!-- Detectar si se viene desde tratamiento.index -->
            @if (request('volver_a_index'))
                <input type="hidden" name="volver_a_index" value="1">
            @endif

            <!-- Columna izquierda -->
            <div class="space-y-4">
                <label class="block">
                    <span class="text-lg">Nombre</span>
                    <input name="nombre" type="text" required
                           class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222]">
                </label>

                <label class="block">
                    <span class="text-lg">Indicación</span>
                    <input name="indicacion" type="text" required
                           class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222]">
                </label>

                <label class="block">
                    <span class="text-lg">Presentación</span>
                    <select name="presentacion" required
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222] bg-white">
                        <option value="comprimidos">Comprimidos</option>
                        <option value="jarabe">Jarabe</option>
                        <option value="gotas">Gotas</option>
                        <option value="inyeccion">Inyección</option>
                        <option value="pomada">Pomada</option>
                        <option value="parche">Parche</option>
                        <option value="polvo">Polvo</option>
                        <option value="spray">Spray</option>
                        <option value="otro">Otro</option>
                    </select>
                </label>
            </div>

            <!-- Columna derecha -->
            <div class="space-y-4">
                <label class="block">
                    <span class="text-lg">Vía</span>
                    <select name="via" required
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222] bg-white">
                        <option value="oral">Oral</option>
                        <option value="topica">Tópica</option>
                        <option value="nasal">Nasal</option>
                        <option value="ocular">Ocular</option>
                        <option value="otica">Ótica</option>
                        <option value="intravenosa">Intravenosa</option>
                        <option value="intramuscular">Intramuscular</option>
                        <option value="subcutanea">Subcutánea</option>
                        <option value="rectal">Rectal</option>
                        <option value="inhalatoria">Inhalatoria</option>
                        <option value="otro">Otro</option>
                    </select>
                </label>

                <label class="block">
                    <span class="text-lg">Dosis</span>
                    <input name="dosis" type="text" required
                           class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222]">
                </label>

                <div class="flex space-x-4">
                    <label class="block w-1/2">
                        <span class="text-lg">Pauta (cada...)</span>
                        <input name="pauta_intervalo" type="number" min="1" required
                               class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222]">
                    </label>

                    <label class="block w-1/2">
                        <span class="text-lg">Unidad</span>
                        <select name="pauta_unidad" required
                                class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222] bg-white">
                            <option value="horas">Horas</option>
                            <option value="dias">Días</option>
                            <option value="semanas">Semanas</option>
                            <option value="meses">Meses</option>
                        </select>
                    </label>
                </div>

                <label class="block">
                    <span class="text-lg">Primera toma</span>
                    <input name="fecha_hora_inicio" type="datetime-local" required
                           class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222]">
                </label>
            </div>

            <div class="md:col-span-2">
                <label class="block">
                    <span class="text-lg">Observaciones</span>
                    <textarea name="observaciones" rows="4"
                              class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222]"></textarea>
                </label>
            </div>

            <div class="md:col-span-2 flex justify-center gap-6 pt-8">
                <button type="submit" name="accion" value="add"
                        class="bg-yellow-300 text-[#0C1222] font-bold px-8 py-3 rounded-full hover:bg-yellow-200 transition">
                    Añadir otra
                </button>

                <button type="submit" name="accion" value="done"
                        class="bg-blue-300 text-[#0C1222] font-bold px-8 py-3 rounded-full hover:bg-blue-200 transition">
                    Finalizar
                </button>
            </div>
        </form>
    </div>
</main>
@endsection
