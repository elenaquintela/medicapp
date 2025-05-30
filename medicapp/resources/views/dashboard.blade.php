@extends('layouts.auth')

@section('content')
<div class="flex flex-1 h-full">
    <main class="flex-1 px-8 py-6 space-y-12">

        <!-- Sección HOY -->
        <section>
            <h2 class="text-orange-400 text-xl font-bold mb-2">HOY</h2>
            <h3 class="text-2xl font-bold mb-4">Recordatorios</h3>

            <table class="w-full text-center border border-white">
                <thead class="bg-[#0C1222]">
                    <tr class="border-b border-white">
                        <th class="p-2">Hora</th>
                        <th class="p-2">Medicamento</th>
                        <th class="p-2">Tomado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-white">
                        <td class="p-2">08:00</td>
                        <td class="p-2">Paracetamol 1g</td>
                        <td class="p-2 text-green-500 text-2xl">✔️</td>
                    </tr>
                    <tr>
                        <td class="p-2">13:00</td>
                        <td class="p-2">Omeprazol 20mg</td>
                        <td class="p-2 border border-green-400 w-6 h-6 mx-auto"></td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Sección Próximas Citas -->
        <section>
            <h2 class="text-orange-400 text-xl font-bold mb-4">PRÓXIMAS CITAS</h2>

            @if ($perfilActivo && $perfilActivo->citas->count())
                <table class="w-full text-center border border-white">
                    <thead>
                        <tr class="border-b border-white">
                            <th class="p-2">Fecha</th>
                            <th class="p-2">Hora</th>
                            <th class="p-2">Especialidad - Lugar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($perfilActivo->citas->sortBy(['fecha', 'hora_inicio']) as $cita)
                            <tr class="border-b border-white">
                                <td class="p-2">{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</td>
                                <td class="p-2">{{ \Carbon\Carbon::parse($cita->hora_inicio)->format('H:i') }}</td>
                                <td class="p-2">{{ $cita->especialidad }} - {{ $cita->ubicacion }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-white">No hay citas registradas para este perfil.</p>
            @endif
        </section>

        <!-- Tratamientos activos -->
        <section>
            <h2 class="text-orange-400 text-xl font-bold mb-4">TRATAMIENTOS ACTIVOS</h2>

            <!-- Pestañas de tratamientos -->
            <div class="flex space-x-2">
                @forelse ($tratamientos as $key => $tratamiento)
                    <button type="button"
                            onclick="mostrarTratamiento('{{ $tratamiento->id_tratamiento }}')"
                            class="tratamiento-tab bg-white text-[#0C1222] font-semibold px-4 py-2 rounded-t-md"
                            id="tab-{{ $tratamiento->id_tratamiento }}">
                        {{ $tratamiento->causa }}
                    </button>
                @empty
                    <p class="text-white">No hay tratamientos registrados.</p>
                @endforelse

                @if ($perfilActivo)
                    <a href="{{ route('tratamiento.create', ['perfil' => $perfilActivo->id_perfil]) }}">
                        <button type="button" class="bg-green-300 hover:bg-green-400 text-[#0C1222] font-bold px-4 py-2 rounded-t-md">
                            +
                        </button>
                    </a>
                @endif
            </div>

            <!-- Contenido dinámico del tratamiento -->
            @foreach ($tratamientos as $key => $tratamiento)
                <div id="tratamiento-{{ $tratamiento->id_tratamiento }}"
                     class="tratamiento-content bg-blue-100 text-[#0C1222] rounded-b-md p-6 shadow {{ $key !== 0 ? 'hidden' : '' }}">

                    @if ($tratamiento->medicaciones && $tratamiento->medicaciones->isNotEmpty())
                        <ul class="list-disc pl-5 space-y-4">
                            @foreach ($tratamiento->medicaciones as $med)
                                <li>
                                    <strong>{{ $med->medicamento->nombre ?? '(Sin nombre)' }}</strong>
                                    <ul class="list-none pl-3 text-sm space-y-1">
                                        <li><span class="font-semibold">Dosis:</span> {{ $med->dosis }}</li>
                                        <li><span class="font-semibold">Vía:</span> {{ $med->via }}</li>
                                        <li><span class="font-semibold">Pauta:</span> cada {{ $med->pauta_intervalo }} {{ $med->pauta_unidad }}</li>
                                        @if ($med->observaciones)
                                            <li><span class="font-semibold">Observaciones:</span> {{ $med->observaciones }}</li>
                                        @endif
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No hay medicaciones registradas para este tratamiento.</p>
                    @endif
                </div>
            @endforeach
        </section>
    </main>
</div>

<script>
    function mostrarTratamiento(id) {
        const contenidos = document.querySelectorAll('.tratamiento-content');
        const pestañas = document.querySelectorAll('.tratamiento-tab');

        contenidos.forEach(div => div.classList.add('hidden'));
        pestañas.forEach(btn => {
            btn.classList.remove('bg-blue-100', 'font-bold');
            btn.classList.add('bg-white');
        });

        document.getElementById(`tratamiento-${id}`).classList.remove('hidden');
        const activeTab = document.getElementById(`tab-${id}`);
        activeTab.classList.remove('bg-white');
        activeTab.classList.add('bg-blue-100', 'font-bold');
    }

    document.addEventListener('DOMContentLoaded', () => {
        const primeraPestaña = document.querySelector('.tratamiento-tab');
        if (primeraPestaña) {
            primeraPestaña.click();
        }
    });
</script>
@endsection
