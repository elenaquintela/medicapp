@extends('layouts.auth')

@section('content')
<div class="flex flex-1 h-full">
    <main class="flex-1 px-4 sm:px-6 lg:px-8 py-4 sm:py-6 space-y-8 sm:space-y-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 lg:gap-12 items-start">
            <section class="flex flex-col">
                <div class="mb-4">
                    <h2 class="text-orange-400 text-lg sm:text-xl font-bold mb-2">HOY</h2>
                    <h3 class="text-xl sm:text-2xl font-bold">Recordatorios</h3>
                </div>
                <div class="flex-1 overflow-x-auto">
                    <!-- Versión móvil: Cards -->
                    <div class="sm:hidden space-y-3">
                        @forelse ($recordatorios as $rec)
                            <div class="bg-gray-800/50 border border-gray-600 rounded-lg p-4 transition-opacity duration-700" data-row-id="{{ $rec->id }}">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="text-orange-400 font-bold">
                                        @if($rec->fecha_hora->isToday())
                                            {{ $rec->fecha_hora->format('H:i') }}
                                        @else
                                            {{ $rec->fecha_hora->format('d/m H:i') }}
                                        @endif
                                    </div>
                                    <input type="checkbox"
                                           class="recordatorio-check h-5 w-5 accent-green-500"
                                           data-id="{{ $rec->id }}"
                                           {{ $rec->tomado ? 'checked' : '' }}>
                                </div>
                                <div class="text-white font-medium mb-1">
                                    {{ $rec->tratamientoMedicamento->medicamento->nombre ?? 'Desconocido' }}
                                    {{ $rec->tratamientoMedicamento->dosis ? ' ' . $rec->tratamientoMedicamento->dosis : '' }}
                                </div>
                                @if($rec->tratamientoMedicamento->observaciones)
                                    <div class="text-xs text-gray-300 italic">
                                        {{ $rec->tratamientoMedicamento->observaciones }}
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-300">No hay recordatorios para hoy.</div>
                        @endforelse
                    </div>
                    
                    <!-- Versión desktop: Tabla -->
                    <table class="hidden sm:table w-full text-center border border-white">
                        <thead class="bg-blue-400 text-black uppercase font-bold">
                            <tr class="border-b border-white">
                                <th class="p-2 text-xs sm:text-sm">Hora</th>
                                <th class="p-2 text-xs sm:text-sm">Medicamento</th>
                                <th class="p-2 text-xs sm:text-sm hidden lg:table-cell">Observaciones</th>
                                <th class="p-2 text-xs sm:text-sm">Tomado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recordatorios as $rec)
                                <tr class="border-b border-white transition-opacity duration-700 text-white" data-row-id="{{ $rec->id }}">
                                    <td class="p-2 text-xs sm:text-sm">
                                        @if($rec->fecha_hora->isToday())
                                            {{ $rec->fecha_hora->format('H:i') }}
                                        @else
                                            {{ $rec->fecha_hora->format('d/m H:i') }}
                                        @endif
                                    </td>
                                    <td class="p-2 text-xs sm:text-sm">
                                        {{ $rec->tratamientoMedicamento->medicamento->nombre ?? 'Desconocido' }}
                                        {{ $rec->tratamientoMedicamento->dosis ? ' ' . $rec->tratamientoMedicamento->dosis : '' }}
                                    </td>
                                    <td class="p-2 text-xs sm:text-sm italic hidden lg:table-cell">
                                        {{ $rec->tratamientoMedicamento->observaciones ?? '—' }}
                                    </td>
                                    <td class="p-2">
                                        <input type="checkbox"
                                               class="recordatorio-check h-5 w-5 sm:h-6 sm:w-6 accent-green-500"
                                               data-id="{{ $rec->id }}"
                                               {{ $rec->tomado ? 'checked' : '' }}>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-4 text-gray-300 text-xs sm:text-sm">No hay recordatorios para hoy.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
            <section class="flex flex-col">
                <div class="mb-4">
                    <h2 class="text-orange-400 text-lg sm:text-xl font-bold mb-2">PRÓXIMAS CITAS</h2>
                    <h3 class="text-xl sm:text-2xl font-bold hidden lg:block">&nbsp;</h3>
                </div>
                <div class="flex-1 overflow-x-auto">
                    @if ($perfilActivo && $perfilActivo->citas->count())
                        <!-- Versión móvil: Cards -->
                        <div class="sm:hidden space-y-3">
                            @foreach ($perfilActivo->citas->sortBy('fecha')->take(5) as $cita)
                                <div class="bg-gray-800/50 border border-gray-600 rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="text-orange-400 font-bold text-sm">
                                            {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}
                                        </div>
                                        <div class="text-white font-medium">
                                            {{ \Carbon\Carbon::parse($cita->hora_inicio)->format('H:i') }}
                                        </div>
                                    </div>
                                    <div class="text-sm flex items-center gap-2 min-w-0">
                                        <span class="text-white font-medium whitespace-nowrap">
                                            {{ $cita->especialidad ?? '—' }}
                                        </span>
                                        @php $lugar = $cita->lugar ?? $cita->ubicacion; @endphp
                                        @if($lugar)
                                            <span class="text-white font-medium truncate">— {{ $lugar }}</span>
                                        @endif
                                    </div>

                                    @if($cita->notas)
                                        <div class="text-xs text-gray-300 italic mt-2">
                                            {{ Str::limit($cita->notas, 60) }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Versión desktop: Tabla -->
                        <table class="hidden sm:table w-full text-center border border-white">
                            <thead class="bg-blue-400 text-black uppercase font-bold">
                                <tr class="border-b border-white">
                                    <th class="p-2 text-xs sm:text-sm">Fecha</th>
                                    <th class="p-2 text-xs sm:text-sm">Hora</th>
                                    <th class="p-2 text-xs sm:text-sm">Especialidad - Lugar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($perfilActivo->citas->sortBy(['fecha', 'hora_inicio'])->take(5) as $cita)
                                    <tr class="border-b border-white text-white">
                                        <td class="p-2 text-xs sm:text-sm">{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</td>
                                        <td class="p-2 text-xs sm:text-sm">{{ \Carbon\Carbon::parse($cita->hora_inicio)->format('H:i') }}</td>
                                        <td class="p-2 text-xs sm:text-sm">{{ $cita->especialidad }} - {{ $cita->lugar ?? $cita->ubicacion ?? 'Sin ubicación' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-white">No hay citas registradas para este perfil.</p>
                    @endif
                </div>
            </section>
        </div>
        <section>
            <h2 class="text-orange-400 text-lg sm:text-xl font-bold mb-4">TRATAMIENTOS ACTIVOS</h2>

            <!-- Tabs responsive -->
            <div class="flex flex-wrap gap-1 sm:gap-2 mb-1">
                @forelse ($tratamientos as $key => $tratamiento)
                    <button type="button"
                            onclick="mostrarTratamiento('{{ $tratamiento->id_tratamiento }}')"
                            class="tratamiento-tab bg-white text-[#0C1222] font-semibold 
                                px-3 sm:px-4 py-1 sm:py-2 rounded-t-md 
                                text-sm sm:text-base"
                            id="tab-{{ $tratamiento->id_tratamiento }}">
                        {{ Str::limit($tratamiento->causa, 15) }}
                    </button>

                @empty
                    <p class="text-white text-sm sm:text-base">No hay tratamientos registrados.</p>
                @endforelse

                @if ($perfilActivo)
                    <a href="{{ route('tratamiento.create', ['perfil' => $perfilActivo->id_perfil]) }}">
                        <button type="button" 
                                class="bg-green-300 hover:bg-green-400 text-[#0C1222] font-bold 
                                    px-4 sm:px-4 py-1 sm:py-2 rounded-t-md 
                                    text-sm sm:text-base">
                            +
                        </button>
                    </a>
                @endif
            </div>

            @foreach ($tratamientos as $key => $tratamiento)
                <div id="tratamiento-{{ $tratamiento->id_tratamiento }}"
                     class="tratamiento-content bg-blue-100 text-[#0C1222] rounded-b-md p-3 sm:p-6 -mt-1 sm:-mt-2 shadow {{ $key !== 0 ? 'hidden' : '' }}">
                    @if ($tratamiento->medicaciones && $tratamiento->medicaciones->isNotEmpty())
                        <ul class="list-disc pl-4 sm:pl-5 space-y-2 sm:space-y-4">
                            @foreach ($tratamiento->medicaciones as $med)
                                <li class="text-sm sm:text-base">
                                    <strong>{{ $med->medicamento->nombre ?? '(Sin nombre)' }}</strong>
                                    <ul class="list-none pl-2 sm:pl-3 text-xs sm:text-sm space-y-1 mt-1">
                                        <li><span class="font-semibold">Dosis:</span> {{ $med->dosis }}</li>
                                        <li><span class="font-semibold">Vía:</span> {{ $med->via }}</li>
                                        <li><span class="font-semibold">Pauta:</span> cada {{ $med->pauta_intervalo }} {{ $med->pauta_unidad }}</li>
                                        @if ($med->observaciones)
                                            <li><span class="font-semibold">Obs:</span> {{ Str::limit($med->observaciones, 50) }}</li>
                                        @endif
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm sm:text-base">No hay medicaciones registradas para este tratamiento.</p>
                    @endif
                </div>
            @endforeach
        </section>
    </main>
</div>

<script>
  const timeouts = {};
  const HIDE_DELAY_MS = 500; 
  const FADE_MS = 400;       

  function getReminderNodes(id) {
    return Array.from(document.querySelectorAll(`[data-row-id='${id}']`));
  }

  function getReminderChecks(id) {
    return Array.from(document.querySelectorAll(`.recordatorio-check[data-id='${id}']`));
  }

  async function toggleReminder(e) {
    const checked = e.target.checked;
    const id = e.target.dataset.id;
    const nodes = getReminderNodes(id);

    try {
      const res = await fetch(`/recordatorios/${id}/marcar`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ tomado: checked })
      });
      if (!res.ok) throw new Error();

      
      getReminderChecks(id).forEach(chk => {
        if (chk !== e.target) chk.checked = checked;
      });

      
      if (checked) {
        if (timeouts[id]) {
          clearTimeout(timeouts[id].t1);
          clearTimeout(timeouts[id].t2);
        }
        nodes.forEach(n => n.classList.add('transition-opacity','duration-700'));
        timeouts[id] = {
          t1: setTimeout(() => {
            nodes.forEach(n => n.classList.add('opacity-0'));
            timeouts[id].t2 = setTimeout(() => {
              nodes.forEach(n => n.remove());
              delete timeouts[id];
            }, FADE_MS);
          }, HIDE_DELAY_MS)
        };
      } else {
        if (timeouts[id]) {
          clearTimeout(timeouts[id].t1);
          clearTimeout(timeouts[id].t2);
          delete timeouts[id];
        }
        nodes.forEach(n => n.classList.remove('opacity-0'));
      }
    } catch (err) {
      e.target.checked = !checked;
      alert('Error al actualizar el recordatorio.');
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    const primeraPestaña = document.querySelector('.tratamiento-tab');
    if (primeraPestaña) primeraPestaña.click();

    document.querySelectorAll('.recordatorio-check').forEach(check => {
      check.addEventListener('change', toggleReminder);
    });
  });
</script>
@endsection
