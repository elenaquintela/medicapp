<x-layouts.authenticated :perfilesUsuario="$perfilesUsuario" :perfilActivo="$perfilActivo">
    <div class="flex flex-1 h-full">

        
        

        <!-- Contenido principal -->
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

                <table class="w-full text-center border border-white">
                    <thead>
                        <tr class="border-b border-white">
                            <th class="p-2">Fecha</th>
                            <th class="p-2">Hora</th>
                            <th class="p-2">Especialidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-white">
                            <td class="p-2">12 SEPTIEMBRE</td>
                            <td class="p-2">09:15</td>
                            <td class="p-2">DR. SUÁREZ</td>
                        </tr>
                        <tr class="border-b border-white">
                            <td class="p-2">23 SEPTIEMBRE</td>
                            <td class="p-2">08:00</td>
                            <td class="p-2">ENFERMERÍA - CENTRO DE SALUD</td>
                        </tr>
                        <tr>
                            <td class="p-2">11 NOVIEMBRE</td>
                            <td class="p-2">11:00</td>
                            <td class="p-2">RADIOLOGÍA - CHUS</td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <!-- Tratamientos activos -->
            <section>
                <h2 class="text-orange-400 text-xl font-bold mb-4">TRATAMIENTOS ACTIVOS</h2>

                <!-- Pestañas de tratamientos -->
                <div class="flex space-x-2">
                    @forelse ($tratamientos as $tratamiento)
                        <button class="bg-gray-300 text-[#0C1222] font-semibold px-4 py-2 rounded-t-md">
                            {{ $tratamiento->causa }}
                        </button>
                    @empty
                        <p class="text-white">No hay tratamientos registrados.</p>
                    @endforelse
                
                    {{-- Botón para añadir tratamiento --}}
                    <a href="{{ route('tratamiento.create', ['perfil' => $perfilActivo->id_perfil]) }}">
                        <button type="button" class="bg-green-300 hover:bg-green-400 text-[#0C1222] font-bold px-4 py-2 rounded-t-md">
                            +
                        </button>
                    </a>
                    
                </div>
                

                <!-- Contenido de la pestaña activa -->
                <div class="bg-blue-100 text-[#0C1222] rounded-b-md p-6 shadow">
                    <p>Aquí irá la información del tratamiento seleccionado.</p>
                </div>
            </section>

        </main>
    </div>
</x-layouts.authenticated>
