@extends('layouts.auth')

@section('title', 'Citas médicas – MedicApp')

@section('content')
@php
    $rol = Auth::user()->rol_global;
@endphp

<div class="flex flex-col px-4 sm:px-6 lg:px-10 pt-4 sm:pt-6 h-full">
    <h2 class="text-2xl sm:text-3xl font-bold mb-6 sm:mb-8 text-center">Citas médicas</h2>

    <form method="GET" action="{{ route('cita.index') }}" class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-6 w-full">
        <img src="{{ asset('filtro.png') }}" alt="Filtro"
             class="h-8 sm:h-12 aspect-auto object-contain brightness-0 invert flex-shrink-0" />

        <input type="text"
               id="filtro-citas"
               name="busqueda"
               value="{{ request('busqueda') }}"
               class="w-full p-2 sm:p-3 rounded-md text-black placeholder-gray-600 text-xs sm:text-sm"
               placeholder="Filtre por fecha, hora, especialista-lugar, motivo u observaciones" />
    </form>

    <div class="flex w-full items-start">
        <div class="w-full overflow-x-auto">
            {{-- Versión móvil: Cards --}}
            <div class="sm:hidden space-y-3 mb-6">
                @forelse ($citas as $cita)
                    @php
                        $fecha = \Carbon\Carbon::parse($cita->fecha);
                        $hora  = \Carbon\Carbon::parse($cita->hora_inicio);
                        $titulo = trim(($cita->especialidad ? $cita->especialidad . ' - ' : '') . ($cita->ubicacion ?? ''));
                    @endphp
                    <div class="bg-gray-800/50 border border-gray-600 rounded-lg p-4 cita-card">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-3 filtrable">
                                <div class="rounded-xl px-3 py-1 text-sm font-semibold bg-blue-100 text-blue-800">
                                    {{ $fecha->format('d/m/Y') }}
                                </div>
                                <div class="rounded-xl px-3 py-1 text-sm font-semibold bg-blue-100 text-blue-800">
                                    {{ $hora->format('H:i') }}
                                </div>
                            </div>
                            <div class="text-xs px-2 py-1 rounded-lg bg-gray-100/10 text-gray-300">
                                {{ Str::limit($cita->usuarioCreador->nombre ?? 'Desconocido', 18) }}
                            </div>
                        </div>

                        <h4 class="mt-3 font-semibold text-white text-base filtrable">
                            {{ Str::limit($titulo !== '' ? $titulo : 'Cita médica', 40) }}
                        </h4>

                        @if(!empty($cita->motivo))
                            <div class="mt-1 text-sm text-gray-300 filtrable">
                                Motivo: {{ Str::limit($cita->motivo, 80) }}
                            </div>
                        @endif

                        @if(!empty($cita->observaciones))
                            <details class="mt-2">
                                <summary class="text-sm text-blue-300 underline cursor-pointer select-none">Ver observaciones</summary>
                                <p class="mt-2 text-sm text-gray-300 whitespace-pre-line filtrable">
                                    {{ $cita->observaciones }}
                                </p>
                            </details>
                        @endif

                        <div class="mt-4 flex items-center gap-2">
                            <a href="{{ route('cita.edit', $cita->id_cita) }}"
                               class="bg-yellow-300 hover:bg-yellow-200 text-[#0C1222] font-bold py-1 px-3 rounded-full shadow text-sm">
                                Editar
                            </a>
                            {{-- Se elimina el botón "Sincronizar perfil" dentro de cada card móvil --}}
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-300 text-base">No hay citas registradas.</div>
                @endforelse
            </div>

            {{-- Versión desktop: Tabla (se mantiene el estilo) --}}
            <div class="hidden sm:block">
                <table class="w-full text-xs sm:text-sm text-white border border-white">
                    <thead class="bg-blue-400 text-black uppercase text-center">
                        <tr>
                            <th class="py-2 sm:py-3 px-2 sm:px-4">Fecha</th>
                            <th class="py-2 sm:py-3 px-2 sm:px-4">Hora</th>
                            <th class="py-2 sm:py-3 px-2 sm:px-4">Especialista - Lugar</th>
                            <th class="py-2 sm:py-3 px-2 sm:px-4">Motivo</th>
                            <th class="py-2 sm:py-3 px-2 sm:px-4">Observaciones</th>
                            <th class="py-2 sm:py-3 px-2 sm:px-4 hidden md:table-cell">Creado por</th>
                            <th class="py-2 sm:py-3 px-2 sm:px-4">Editar</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-citas" class="text-center">
                        @forelse ($citas as $cita)
                            <tr class="border-t border-white cita-fila">
                                <td class="py-2 sm:py-3 px-2">
                                    {{ \Carbon\Carbon::parse($cita->fecha)->format('d / m / Y') }}
                                </td>
                                <td class="py-2 sm:py-3 px-2">
                                    {{ \Carbon\Carbon::parse($cita->hora_inicio)->format('H:i') }}
                                </td>
                                <td class="py-2 sm:py-3 px-2 filtrable">
                                    {{ $cita->especialidad ? $cita->especialidad . ' - ' : '' }}{{ $cita->ubicacion }}
                                </td>
                                <td class="py-2 sm:py-3 px-2 filtrable">{{ $cita->motivo }}</td>
                                <td class="py-2 sm:py-3 px-2 filtrable">{{ $cita->observaciones }}</td>
                                <td class="py-2 sm:py-3 px-2 font-semibold hidden md:table-cell">
                                    {{ Str::limit($cita->usuarioCreador->nombre ?? 'Desconocido', 20) }}
                                </td>
                                <td class="py-2 sm:py-3 px-2">
                                    <a href="{{ route('cita.edit', $cita->id_cita) }}" class="hover:opacity-80 inline-block" title="Editar">
                                        <img src="{{ asset('editar.png') }}" alt="Editar" class="w-4 h-4 sm:w-6 sm:h-6 object-contain invert mx-auto">
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-4 text-center text-gray-300">No hay citas registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Botonera lateral desktop --}}
        <div class="hidden sm:flex w-[15%] flex-col items-center justify-center gap-6">
            <a href="{{ route('cita.create') }}"
               class="bg-green-400 hover:bg-green-500 text-black rounded-full w-16 h-16 lg:w-20 lg:h-20 flex items-center justify-center shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 lg:w-12 lg:h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" />
                </svg>
            </a>

            @if ($rol === 'premium' && $citas->isNotEmpty())
                <form action="{{ route('google.syncAll') }}" method="POST" class="w-16 h-16 lg:w-20 lg:h-20">
                    @csrf
                    <input type="hidden" name="perfil_id" value="{{ $citas->first()->id_perfil }}">
                    <button type="submit" class="w-full h-full hover:opacity-90 transition" title="Sincronizar todas las citas del perfil activo">
                        <img src="{{ asset('google-sync.png') }}" alt="Sync Google Calendar" class="w-full h-full object-contain">
                    </button>
                </form>
            @elseif ($rol === 'premium' && $citas->isEmpty())
                <div class="w-16 h-16 lg:w-20 lg:h-20 opacity-50 cursor-not-allowed" title="No hay citas que sincronizar">
                    <img src="{{ asset('google-sync.png') }}" alt="Sync Google Calendar" class="w-full h-full object-contain grayscale">
                </div>
            @else
                <div class="w-16 h-16 lg:w-20 lg:h-20 opacity-50 cursor-not-allowed" title="Solo disponible en el plan Premium">
                    <img src="{{ asset('google-sync.png') }}" alt="Sync Google Calendar" class="w-full h-full object-contain grayscale">
                </div>
            @endif
        </div>
    </div>

    {{-- FAB flotante móvil: NUEVA CITA --}}
    <a href="{{ route('cita.create') }}"
       class="fixed bottom-6 right-6 sm:hidden bg-green-400 hover:bg-green-500 text-black rounded-full w-14 h-14 flex items-center justify-center shadow-lg z-20"
       title="Nueva cita">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" />
        </svg>
    </a>

    {{-- FAB flotante móvil: SINCRONIZAR PERFIL --}}
    @if ($rol === 'premium')
        @if ($citas->isNotEmpty())
            <form action="{{ route('google.syncAll') }}" method="POST"
                  class="sm:hidden fixed right-6 bottom-24 z-20">
                @csrf
                <input type="hidden" name="perfil_id" value="{{ $citas->first()->id_perfil }}">
                <button type="submit"
                        class="bg-white/90 hover:bg-white text-[#0C1222] rounded-full w-14 h-14 flex items-center justify-center shadow-lg"
                        title="Sincronizar todas las citas del perfil activo">
                    <img src="{{ asset('google-sync.png') }}" alt="Sync Google Calendar" class="w-8 h-8 object-contain">
                </button>
            </form>
        @else
            <div class="sm:hidden fixed right-6 bottom-24 z-20 opacity-60 cursor-not-allowed"
                 title="No hay citas que sincronizar">
                <div class="bg-white/70 rounded-full w-14 h-14 flex items-center justify-center shadow-lg">
                    <img src="{{ asset('google-sync.png') }}" alt="Sync Google Calendar" class="w-8 h-8 object-contain grayscale">
                </div>
            </div>
        @endif
    @else
        <div class="sm:hidden fixed right-6 bottom-24 z-20 opacity-60 cursor-not-allowed"
             title="Solo disponible en el plan Premium">
            <div class="bg-white/70 rounded-full w-14 h-14 flex items-center justify-center shadow-lg">
                <img src="{{ asset('google-sync.png') }}" alt="Sync Google Calendar" class="w-8 h-8 object-contain grayscale">
            </div>
        </div>
    @endif
</div>

<style>
    .resaltado {
        background-color: #bfdbfe;
        color: #0c1222;
        font-weight: bold;
        padding: 0 2px;
        border-radius: 3px;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const input = document.getElementById('filtro-citas');

  const filas = Array.from(document.querySelectorAll('.cita-fila'));
  const cards = Array.from(document.querySelectorAll('.cita-card'));

  const TARGET_SELECTOR = 'td.filtrable, .filtrable';

  function guardarOriginal(el) {
    const esAccion = el.querySelector?.('a,button,form,img,svg');
    if (!esAccion && !el.hasAttribute('data-original-html')) {
      el.setAttribute('data-original-html', el.innerHTML);
    }
  }

  filas.forEach(fila => fila.querySelectorAll(TARGET_SELECTOR).forEach(guardarOriginal));
  cards.forEach(card => card.querySelectorAll(TARGET_SELECTOR).forEach(guardarOriginal));

  function resaltar(el, texto) {
    const base = el.getAttribute('data-original-html');
    if (!base) return;
    if (!texto) { el.innerHTML = base; return; }
    const regex = new RegExp('(' + texto.replace(/[.*+?^${}()|[\\]\\\\]/g, '\\\\$&') + ')', 'gi');
    el.innerHTML = base.replace(regex, '<span class="resaltado">$1</span>');
  }

  function filtraColeccion(items, getTargets, setVisible) {
    const texto = (input.value || '').toLowerCase().trim();
    items.forEach(item => {
      const targets = getTargets(item);
      let coincide = false;

      targets.forEach(el => {
        const esAccion = el.querySelector?.('a,button,form,img,svg');
        const contenido = (el.textContent || '').toLowerCase();
        if (!esAccion) {
          if (texto && contenido.includes(texto)) {
            coincide = true;
            resaltar(el, texto);
          } else {
            resaltar(el, '');
            if (texto && !coincide && contenido.includes(texto)) coincide = true;
          }
        } else {
          if (texto && contenido.includes(texto)) coincide = true;
        }
      });

      setVisible(item, (coincide || texto === ''));
    });
  }

  input.addEventListener('input', function () {
    filtraColeccion(
      filas,
      (fila) => Array.from(fila.querySelectorAll(TARGET_SELECTOR)),
      (fila, visible) => { fila.style.display = visible ? '' : 'none'; }
    );

    filtraColeccion(
      cards,
      (card) => Array.from(card.querySelectorAll(TARGET_SELECTOR)),
      (card, visible) => { card.style.display = visible ? '' : 'none'; }
    );
  });
});
</script>

@endsection
