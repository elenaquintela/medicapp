@extends('layouts.auth')

@section('content')
<div class="flex flex-1 h-full">
    <main class="flex-1 px-8 py-6 space-y-12">

        <!-- Sección HOY -->
        <section>
            <h2 class="text-orange-400 text-xl font-bold mb-2">HOY</h2>
            <h3 class="text-2xl font-bold mb-4">Recordatorios</h3>

            <table class="w-full text-center border border-white">
                <thead class="bg-blue-400 text-black uppercase font-bold">
                    <tr class="border-b border-white">
                        <th class="p-2">Fecha</th>
                        <th class="p-2">Hora</th>
                        <th class="p-2">Medicamento</th>
                        <th class="p-2">Observaciones</th>
                        <th class="p-2">Tomado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recordatorios as $rec)
                        <tr class="border-b border-white {{ $rec->tomado ? 'bg-green-100 text-[#0C1222]' : 'text-white' }}" data-row-id="{{ $rec->id }}">
                            <td class="p-2">
                                {{ \Carbon\Carbon::parse($rec->fecha_hora)->format('d/m/Y') }}
                            </td>
                            <td class="p-2">
                                {{ \Carbon\Carbon::parse($rec->fecha_hora)->format('H:i') }}
                            </td>
                            <td class="p-2">
                                {{ $rec->tratamientoMedicamento->medicamento->nombre ?? 'Desconocido' }}
                                {{ $rec->tratamientoMedicamento->dosis ? ' ' . $rec->tratamientoMedicamento->dosis : '' }}
                            </td>
                            <td class="p-2 text-sm italic">
                                {{ $rec->tratamientoMedicamento->observaciones ?? '—' }}
                            </td>
                            <td class="p-2">
                                <input type="checkbox"
                                       class="recordatorio-check h-6 w-6 accent-green-500"
                                       data-id="{{ $rec->id }}"
                                       {{ $rec->tomado ? 'checked' : '' }}>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-gray-300">No hay recordatorios para hoy.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        <!-- Sección Próximas Citas -->
        <section>
            <h2 class="text-orange-400 text-xl font-bold mb-4">PRÓXIMAS CITAS</h2>

            @if ($perfilActivo && $perfilActivo->citas->count())
                <table class="w-full text-center border border-white">
                    <thead class="bg-blue-400 text-black uppercase font-bold">
                        <tr class="border-b border-white">
                            <th class="p-2">Fecha</th>
                            <th class="p-2">Hora</th>
                            <th class="p-2">Especialidad - Lugar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($perfilActivo->citas->sortBy(['fecha', 'hora_inicio']) as $cita)
                            <tr class="border-b border-white text-white">
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

        document.querySelectorAll('.recordatorio-check').forEach(check => {
            check.addEventListener('change', async (e) => {
                const id = e.target.dataset.id;
                const row = document.querySelector(`tr[data-row-id='${id}']`);

                try {
                    const res = await fetch(`/recordatorios/${id}/marcar`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ tomado: e.target.checked })
                    });

                    if (res.ok) {
                        row.classList.toggle('bg-green-100', e.target.checked);
                        row.classList.toggle('text-[#0C1222]', e.target.checked);
                        row.classList.toggle('text-white', !e.target.checked);
                    } else {
                        alert('Error al actualizar el recordatorio.');
                        e.target.checked = !e.target.checked;
                    }
                } catch (error) {
                    alert('Error de conexión.');
                    e.target.checked = !e.target.checked;
                }
            });
        });
    });
</script>
@endsection
