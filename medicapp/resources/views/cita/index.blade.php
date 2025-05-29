<x-layouts.authenticated :perfilesUsuario="$perfilesUsuario" :perfilActivo="$perfilActivo">
    <div class="flex flex-col px-10 pt-6 h-full">

        <!-- Título centrado -->
        <h2 class="text-3xl font-bold mb-8 text-center">Citas médicas</h2>

        <!-- Mensaje de éxito -->
        @if (session('success'))
            <div class="mb-6 bg-green-500 text-white px-4 py-3 rounded shadow text-center">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filtro con icono -->
        <div class="flex items-center gap-3 mb-6 w-full max-w-[85%]">
            <img src="{{ asset('filtro.png') }}" alt="Filtro"
                class="h-12 aspect-auto object-contain brightness-0 invert" />

            <input type="text"
                class="w-full p-3 rounded-md text-black placeholder-gray-600 text-sm"
                placeholder="Filtre por fecha, hora, especialista-lugar, motivo o creador" />
        </div>

        <!-- Contenedor tabla + botones -->
        <div class="flex w-full items-start">

            <!-- Tabla de citas -->
            <div class="max-w-[85%] w-full overflow-x-auto mx-auto">
                <table class="w-full text-sm text-white border border-white">
                    <thead class="bg-blue-400 text-black uppercase text-center">
                        <tr>
                            <th class="py-3 px-4">Fecha</th>
                            <th class="py-3 px-4">Hora</th>
                            <th class="py-3 px-4">Especialista - Lugar</th>
                            <th class="py-3 px-4">Motivo</th>
                            <th class="py-3 px-4">Observaciones</th> 
                            <th class="py-3 px-4">Creado por</th>
                            <th class="py-3 px-4">Editar</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($citas as $cita)
                            <tr class="border-t border-white">
                                <td class="py-3">
                                    {{ \Carbon\Carbon::parse($cita->fecha)->format('d / m / Y') }}
                                </td>
                                <td class="py-3">
                                    {{ \Carbon\Carbon::parse($cita->hora_inicio)->format('H:i') }}
                                </td>
                                <td class="py-3">
                                    {{ $cita->especialidad ? $cita->especialidad . ' - ' : '' }}
                                    {{ $cita->ubicacion }}
                                </td>
                                <td class="py-3">{{ $cita->motivo }}</td>
                                <td class="py-3">{{ $cita->observaciones }}</td> 
                                <td class="py-3">
                                    {{ $cita->usuarioCreador->nombre ?? 'Desconocido' }}
                                </td>
                                
                                <td class="py-3">
                                    <a href="{{ route('cita.edit', $cita->id_cita) }}" class="hover:opacity-80 inline-block">
                                        <img src="{{ asset('editar.png') }}" alt="Editar" class="w-6 h-6 object-contain invert mx-auto">
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


            <!-- Botones -->
            <div class="w-[15%] flex flex-col items-center justify-center gap-6">
                <!-- Botón + -->
                <a href="{{ route('cita.create') }}"
                   class="bg-green-400 hover:bg-green-500 text-black rounded-full w-20 h-20 flex items-center justify-center shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" />
                    </svg>
                </a>

                <!-- Google Calendar -->
                <div class="w-20 h-20">
                    <img src="{{ asset('google-sync.png') }}" alt="Sync Google Calendar" class="w-full h-full object-contain">
                </div>
            </div>

        </div>
    </div>
</x-layouts.authenticated>
