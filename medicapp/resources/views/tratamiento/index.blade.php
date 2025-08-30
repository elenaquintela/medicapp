@extends('layouts.auth')

@section('title', 'Tratamientos – MedicApp')

@section('content')
@php
    $rol = Auth::user()->rol_global;
    $activos = $tratamientos->where('estado', 'activo');
    $archivados = $tratamientos->where('estado', 'archivado');
@endphp

<div class="flex flex-col px-4 sm:px-6 lg:px-10 pt-4 sm:pt-6 h-full">
    <h2 class="text-2xl sm:text-3xl font-bold mb-6 sm:mb-8 text-center">Tratamientos</h2>

    <form method="GET" action="{{ route('tratamiento.index') }}" class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-6 w-full">
        <img src="{{ asset('filtro.png') }}" alt="Filtro"
             class="h-8 sm:h-12 aspect-auto object-contain brightness-0 invert flex-shrink-0" />

        <input type="text"
               name="busqueda"
               id="busqueda"
               value="{{ request('busqueda') }}"
               class="w-full p-2 sm:p-3 rounded-md text-black placeholder-gray-600 text-xs sm:text-sm"
               placeholder="Filtre por causa, estado, fecha o creador" />
    </form>
    
    <div class="flex w-full items-start">
        <div class="w-full overflow-x-auto">
            <h3 class="text-lg sm:text-xl font-semibold text-white mb-2">Activos</h3>
            
            <!-- Versión móvil: Cards -->
            <div class="sm:hidden space-y-3 mb-6">
                @forelse ($activos as $tratamiento)
                    <div class="bg-gray-800/50 border border-gray-600 rounded-lg p-4 tratamiento-fila fila-activo">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-semibold text-white text-base">{{ Str::limit($tratamiento->causa, 30) }}</h4>
                        </div>
                        <div class="text-sm text-gray-300 mb-2">
                            <div>Inicio: {{ \Carbon\Carbon::parse($tratamiento->fecha_inicio)->format('d/m/Y') }}</div>
                            <div>Por: {{ $tratamiento->usuarioCreador->nombre ?? 'Desconocido' }}</div>
                        </div>
                        <div class="flex justify-between items-center space-x-2">
                            <a href="{{ route('tratamiento.show', $tratamiento->id_tratamiento) }}" 
                               class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded-full shadow text-sm">
                                Ver detalles
                            </a>
                            <form method="POST" action="{{ route('tratamiento.archivar', $tratamiento->id_tratamiento) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded-full shadow text-sm">
                                    Archivar
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-300 text-base">No hay tratamientos activos.</div>
                @endforelse
            </div>

            
            <!-- Versión desktop: Tabla -->
            <div class="hidden sm:block">
                <table class="w-full text-xs sm:text-sm text-white border border-white">
                    <thead class="bg-blue-400 text-black uppercase text-center">
                        <tr>
                            <th class="py-2 sm:py-3 px-2 sm:px-4">Causa</th>
                            <th class="py-2 sm:py-3 px-2 sm:px-4">Estado</th>
                            <th class="py-2 sm:py-3 px-2 sm:px-4 hidden lg:table-cell">Fecha de inicio</th>
                            <th class="py-2 sm:py-3 px-2 sm:px-4 hidden md:table-cell">Creado por</th>
                            <th class="py-2 sm:py-3 px-2 sm:px-4">Ver detalles</th>
                            <th class="py-2 sm:py-3 px-2 sm:px-4">Archivar</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-tratamientos-activos" class="text-center">
                        @forelse ($activos as $tratamiento)
                            <tr class="border-t border-white tratamiento-fila fila-activo">
                                <td class="py-2 sm:py-3 px-2">{{ Str::limit($tratamiento->causa, 20) }}</td>
                                <td class="py-2 sm:py-3 px-2">{{ ucfirst($tratamiento->estado) }}</td>
                                <td class="py-2 sm:py-3 px-2 hidden lg:table-cell">{{ \Carbon\Carbon::parse($tratamiento->fecha_inicio)->format('d / m / Y') }}</td>
                                <td class="py-2 sm:py-3 px-2 font-semibold hidden md:table-cell">
                                    {{ Str::limit($tratamiento->usuarioCreador->nombre ?? 'Desconocido', 15) }}
                                </td>
                                <td class="py-2 sm:py-3 px-2">
                                    <a href="{{ route('tratamiento.show', $tratamiento->id_tratamiento) }}" class="hover:opacity-80 inline-block">
                                        <img src="{{ asset('detalles.png') }}" alt="Detalles" class="w-4 h-4 sm:w-6 sm:h-6 object-contain invert mx-auto">
                                    </a>
                                </td>
                                <td class="py-2 sm:py-3 px-2">
                                    <form method="POST" action="{{ route('tratamiento.archivar', $tratamiento->id_tratamiento) }}">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 sm:py-1.5 px-2 sm:px-4 rounded-full shadow text-xs sm:text-sm">
                                            Archivar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-center text-gray-300 text-xs sm:text-sm">No hay tratamientos activos.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-8 sm:mt-10">
                <h3 class="text-lg sm:text-xl font-semibold text-white mb-2">Archivados</h3>
                
                <!-- Versión móvil: Cards -->
            <div class="sm:hidden space-y-3 mb-6">
                @forelse ($archivados as $tratamiento)
                    <div class="bg-gray-700/50 border border-gray-500 rounded-lg p-4 tratamiento-fila fila-archivado">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-semibold text-white text-base">{{ Str::limit($tratamiento->causa, 30) }}</h4>
                        </div>
                        <div class="text-sm text-gray-300 mb-3">
                            <div>Inicio: {{ \Carbon\Carbon::parse($tratamiento->fecha_inicio)->format('d/m/Y') }}</div>
                            <div>Por: {{ $tratamiento->usuarioCreador->nombre ?? 'Desconocido' }}</div>
                        </div>
                        <div class="flex justify-between items-center space-x-2">
                            <form method="POST" action="{{ route('tratamiento.reactivar', $tratamiento->id_tratamiento) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                        class="bg-green-400 hover:bg-green-500 text-black font-bold py-1 px-3 rounded-full shadow text-sm">
                                    Reactivar
                                </button>
                            </form>
                            <form method="POST"
                                action="{{ route('tratamiento.destroy', $tratamiento->id_tratamiento) }}"
                                onsubmit="return confirm('¿Eliminar definitivamente este tratamiento archivado?');"
                                class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-full shadow inline-flex items-center justify-center"
                                        title="Eliminar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-1 1v1H4a1 1 0 000 2h12a1 1 0 100-2h-4V3a1 1 0 00-1-1H9zM5 7a1 1 0 011-1h8a1 1 0 011 1v9a2 2 0 01-2 2H7a2 2 0 01-2-2V7zm3 1a1 1 0 10-2 0v8a1 1 0 102 0V8zm4 0a1 1 0 10-2 0v8a1 1 0 102 0V8z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-300 text-base">No hay tratamientos archivados.</div>
                @endforelse
            </div>

                
                <!-- Versión desktop: Tabla -->
                <div class="hidden sm:block">
                    <table class="w-full text-xs sm:text-sm text-white border border-white">
                        <thead class="bg-gray-400 text-black uppercase text-center">
                            <tr>
                                <th class="py-2 sm:py-3 px-2 sm:px-4">Causa</th>
                                <th class="py-2 sm:py-3 px-2 sm:px-4">Estado</th>
                                <th class="py-2 sm:py-3 px-2 sm:px-4 hidden lg:table-cell">Fecha de inicio</th>
                                <th class="py-2 sm:py-3 px-2 sm:px-4 hidden md:table-cell">Creado por</th>
                                <th class="py-2 sm:py-3 px-2 sm:px-4">Reactivar</th>
                                <th class="py-2 sm:py-3 px-2 sm:px-4">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-tratamientos-archivados" class="text-center">
                            @forelse ($archivados as $tratamiento)
                                <tr class="border-t border-white tratamiento-fila fila-archivado">
                                    <td class="py-2 sm:py-3 px-2">{{ Str::limit($tratamiento->causa, 20) }}</td>
                                    <td class="py-2 sm:py-3 px-2">{{ ucfirst($tratamiento->estado) }}</td>
                                    <td class="py-2 sm:py-3 px-2 hidden lg:table-cell">{{ \Carbon\Carbon::parse($tratamiento->fecha_inicio)->format('d / m / Y') }}</td>
                                    <td class="py-2 sm:py-3 px-2 font-semibold hidden md:table-cell">
                                        {{ Str::limit($tratamiento->usuarioCreador->nombre ?? 'Desconocido', 15) }}
                                    </td>
                                    <td class="py-2 sm:py-3 px-2">
                                        <form method="POST" action="{{ route('tratamiento.reactivar', $tratamiento->id_tratamiento) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                    class="bg-green-400 hover:bg-green-500 text-black font-bold py-1 sm:py-1.5 px-2 sm:px-4 rounded-full shadow text-xs sm:text-sm">
                                                Reactivar
                                            </button>
                                        </form>
                                    </td>
                                    <td class="py-2 sm:py-3 px-2">
                                        <form method="POST"
                                            action="{{ route('tratamiento.destroy', $tratamiento->id_tratamiento) }}"
                                            onsubmit="return confirm('¿Eliminar definitivamente este tratamiento archivado?');"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600 text-white p-1.5 sm:p-2 rounded-full shadow inline-flex items-center justify-center"
                                                    title="Eliminar">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-1 1v1H4a1 1 0 000 2h12a1 1 0 100-2h-4V3a1 1 0 00-1-1H9zM5 7a1 1 0 011-1h8a1 1 0 011 1v9a2 2 0 01-2 2H7a2 2 0 01-2-2V7zm3 1a1 1 0 10-2 0v8a1 1 0 102 0V8zm4 0a1 1 0 10-2 0v8a1 1 0 102 0V8z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-center text-gray-300">No hay tratamientos archivados.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- Botón flotante para móvil -->
        <a href="{{ route('tratamiento.create', ['volver_a_index' => 1]) }}"
           class="fixed bottom-6 right-6 sm:hidden bg-green-400 hover:bg-green-500 text-black rounded-full w-14 h-14 flex items-center justify-center shadow-lg z-20">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" />
            </svg>
        </a>

        <!-- Botón lateral para desktop -->
        <div class="hidden sm:flex w-[15%] flex-col items-center justify-center gap-6">
            <a href="{{ route('tratamiento.create', ['volver_a_index' => 1]) }}"
               class="bg-green-400 hover:bg-green-500 text-black rounded-full w-16 h-16 lg:w-20 lg:h-20 flex items-center justify-center shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 lg:w-12 lg:h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" />
                </svg>
            </a>
        </div>

    </div>
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
  const input = document.getElementById('busqueda');
  const filas = document.querySelectorAll('.tratamiento-fila');

  filas.forEach(fila => {
    fila.querySelectorAll('td').forEach(td => {
      const esAccion = td.querySelector('a,button,form,img,svg');
      if (!esAccion && !td.hasAttribute('data-original-html')) {
        td.setAttribute('data-original-html', td.innerHTML);
      }
    });
  });

  function resaltarEnCelda(td, texto) {
    const htmlBase = td.getAttribute('data-original-html');
    if (!htmlBase) return; 
    if (!texto) { td.innerHTML = htmlBase; return; }

    const regex = new RegExp(`(${texto.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
    td.innerHTML = htmlBase.replace(regex, '<span class="resaltado">$1</span>');
  }

  input.addEventListener('input', function () {
    const texto = (input.value || '').toLowerCase().trim();

    filas.forEach(fila => {
      const celdas = fila.querySelectorAll('td');
      let coincide = false;

      celdas.forEach(td => {
        const esAccion = td.querySelector('a,button,form,img,svg');
        const contenido = (td.textContent || '').toLowerCase();

        if (!esAccion) {
          if (texto && contenido.includes(texto)) {
            coincide = true;
            resaltarEnCelda(td, texto);
          } else {
            resaltarEnCelda(td, '');
            if (texto && !coincide && contenido.includes(texto)) coincide = true;
          }
        } else {
            if (texto && contenido.includes(texto)) coincide = true;
        }
      });

      fila.style.display = (coincide || texto === '') ? '' : 'none';
    });
  });
});
</script>

@endsection
