@extends('layouts.auth')

@section('title', 'Tratamientos – MedicApp')

@section('content')
@php
    $rol = Auth::user()->rol_global;
    // Separamos activos y archivados sin tocar el controlador
    $activos = $tratamientos->where('estado', 'activo');
    $archivados = $tratamientos->where('estado', 'archivado');
@endphp

<div class="flex flex-col px-10 pt-6 h-full">

    <!-- Título centrado -->
    <h2 class="text-3xl font-bold mb-8 text-center">Tratamientos</h2>

    <!-- Filtro -->
    <form method="GET" action="{{ route('tratamiento.index') }}" class="flex items-center gap-3 mb-6 w-full max-w-[85%]">
        <img src="{{ asset('filtro.png') }}" alt="Filtro"
             class="h-12 aspect-auto object-contain brightness-0 invert" />

        <input type="text"
               name="busqueda"
               id="busqueda"
               value="{{ request('busqueda') }}"
               class="w-full p-3 rounded-md text-black placeholder-gray-600 text-sm"
               placeholder="Filtre por causa, estado, fecha o creador" />
    </form>

    <!-- Contenedor tabla + botones -->
    <div class="flex w-full items-start">

        <!-- Tabla de tratamientos ACTIVOS -->
        <div class="max-w-[85%] w-full overflow-x-auto mx-auto">
            <h3 class="text-xl font-semibold text-white mb-2">Activos</h3>
            <table class="w-full text-sm text-white border border-white">
                <thead class="bg-blue-400 text-black uppercase text-center">
                    <tr>
                        <th class="py-3 px-4">Causa</th>
                        <th class="py-3 px-4">Estado</th>
                        <th class="py-3 px-4">Fecha de inicio</th>
                        <th class="py-3 px-4">Creado por</th>
                        <th class="py-3 px-4">Ver detalles</th>
                        <th class="py-3 px-4">Archivar</th>
                    </tr>
                </thead>
                <tbody id="tabla-tratamientos-activos" class="text-center">
                    @forelse ($activos as $tratamiento)
                        <tr class="border-t border-white tratamiento-fila fila-activo">
                            <td class="py-3">{{ $tratamiento->causa }}</td>
                            <td class="py-3">{{ ucfirst($tratamiento->estado) }}</td>
                            <td class="py-3">{{ \Carbon\Carbon::parse($tratamiento->fecha_inicio)->format('d / m / Y') }}</td>
                            <td class="py-3 font-semibold">
                                {{ $tratamiento->usuarioCreador->nombre ?? 'Desconocido' }}
                            </td>
                            <td class="py-3">
                                <a href="{{ route('tratamiento.show', $tratamiento->id_tratamiento) }}" class="hover:opacity-80 inline-block">
                                    <img src="{{ asset('detalles.png') }}" alt="Detalles" class="w-6 h-6 object-contain invert mx-auto">
                                </a>
                            </td>
                            <td class="py-3">
                                <form method="POST" action="{{ route('tratamiento.archivar', $tratamiento->id_tratamiento) }}">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white font-bold py-1.5 px-4 rounded-full shadow">
                                        Archivar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-4 text-center text-gray-300">No hay tratamientos activos.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Tabla de TRATAMIENTOS ARCHIVADOS --}}
            <div class="mt-10">
                <h3 class="text-xl font-semibold text-white mb-2">Archivados</h3>
                <table class="w-full text-sm text-white border border-white">
                    <thead class="bg-gray-400 text-black uppercase text-center">
                        <tr>
                            <th class="py-3 px-4">Causa</th>
                            <th class="py-3 px-4">Estado</th>
                            <th class="py-3 px-4">Fecha de inicio</th>
                            <th class="py-3 px-4">Creado por</th>
                            <th class="py-3 px-4">Reactivar</th> {{-- Nueva columna --}}
                            <th class="py-3 px-4">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-tratamientos-archivados" class="text-center">
                        @forelse ($archivados as $tratamiento)
                            <tr class="border-t border-white tratamiento-fila fila-archivado">
                                <td class="py-3">{{ $tratamiento->causa }}</td>
                                <td class="py-3">{{ ucfirst($tratamiento->estado) }}</td>
                                <td class="py-3">{{ \Carbon\Carbon::parse($tratamiento->fecha_inicio)->format('d / m / Y') }}</td>
                                <td class="py-3 font-semibold">
                                    {{ $tratamiento->usuarioCreador->nombre ?? 'Desconocido' }}
                                </td>
                                <td class="py-3">
                                    <form method="POST" action="{{ route('tratamiento.reactivar', $tratamiento->id_tratamiento) }}">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                                class="bg-green-400 hover:bg-green-500 text-black font-bold py-1.5 px-4 rounded-full shadow">
                                            Reactivar
                                        </button>
                                    </form>
                                </td>
                                <td class="py-3">
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

        <!-- Botón añadir tratamiento -->
        <div class="w-[15%] flex flex-col items-center justify-center gap-6">
            <a href="{{ route('tratamiento.create', ['volver_a_index' => 1]) }}"
               class="bg-green-400 hover:bg-green-500 text-black rounded-full w-20 h-20 flex items-center justify-center shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
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

  // Guardar HTML original de celdas "de texto" (no acciones)
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
    if (!htmlBase) return; // acción o ya guardado como vacío
    if (!texto) { td.innerHTML = htmlBase; return; }

    // Como estas celdas son texto plano, podemos sustituir de forma segura
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

        // Para detectar coincidencia usamos el texto visible (no alteramos acciones)
        const contenido = (td.textContent || '').toLowerCase();

        if (!esAccion) {
          if (texto && contenido.includes(texto)) {
            coincide = true;
            resaltarEnCelda(td, texto);
          } else {
            // Restaurar el HTML original (quita resaltados)
            resaltarEnCelda(td, '');
            if (texto && !coincide && contenido.includes(texto)) coincide = true;
          }
        } else {
          // En columnas de acción nunca tocamos innerHTML
          if (texto && contenido.includes(texto)) coincide = true;
        }
      });

      fila.style.display = (coincide || texto === '') ? '' : 'none';
    });
  });
});
</script>

@endsection
