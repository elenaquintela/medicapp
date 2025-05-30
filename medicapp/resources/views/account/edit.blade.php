<x-layouts.authenticated :perfilesUsuario="$perfilesUsuario" :perfilActivo="$perfilActivo">
    <div class="px-10 py-8">
        <h2 class="text-3xl font-bold text-center mb-10">Ajustes de usuario</h2>

        <div class="flex flex-wrap gap-10 justify-center">
            <!-- Columna izquierda: datos -->
            <form method="POST" action="{{ route('account.update') }}"
                  class="bg-[#0C1222] border border-gray-500 rounded-xl p-8 flex-1 min-w-[320px] max-w-md shadow-md">
                @csrf
                @method('PATCH')

                <h3 class="text-yellow-200 font-bold text-xl mb-6">Tus datos</h3>

                <!-- Nombre -->
                <div class="mb-4">
                    <label for="nombre" class="block mb-2 text-white">Nuevo nombre</label>
                    <input type="text" name="nombre" id="nombre"
                           value="{{ old('nombre', $usuario->nombre) }}"
                           class="w-full px-4 py-2 rounded text-black" required>
                </div>

                <!-- Contraseña -->
                <div class="mb-4">
                    <label for="password" class="block mb-2 text-white">Nueva contraseña</label>
                    <input type="password" name="password" id="password"
                           class="w-full px-4 py-2 rounded text-black">
                </div>

                <!-- Confirmar contraseña -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block mb-2 text-white">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="w-full px-4 py-2 rounded text-black">
                </div>

                <!-- Botón guardar -->
                <div class="text-center">
                    <button type="submit"
                            class="bg-green-400 hover:bg-green-500 text-black font-bold py-2 px-6 rounded-full transition">
                        Guardar
                    </button>
                </div>
            </form>

            <!-- Columna derecha: suscripción -->
            <div class="bg-[#0C1222] border border-gray-500 rounded-xl p-8 flex-1 min-w-[320px] max-w-md shadow-md flex flex-col justify-between">
                <div>
                    <h3 class="text-yellow-200 font-bold text-xl mb-6">Tu suscripción</h3>

                    <p class="text-white mb-4 text-lg">
                        Suscripción actual:
                        @if ($usuario->rol_global === 'premium')
                            <span class="text-yellow-200 font-bold">Plan Premium</span>
                        @else
                            <span class="text-yellow-200 font-bold">Plan Estándar</span>
                        @endif
                    </p>

                    @if ($usuario->rol_global === 'premium')
                        <form method="POST" action="{{ route('account.changePlan') }}">
                            @csrf
                            <input type="hidden" name="rol_global" value="estandar">
                            <button type="submit"
                                    class="bg-yellow-200 hover:bg-yellow-300 text-black font-bold py-2 px-6 rounded-full transition">
                                Cambiar suscripción
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('account.changePlan') }}">
                            @csrf
                            <input type="hidden" name="rol_global" value="premium">
                            <button type="submit"
                                    class="bg-yellow-200 hover:bg-yellow-300 text-black font-bold py-2 px-6 rounded-full transition">
                                Hazte Premium
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Eliminar cuenta -->
               
                <!-- Botón que abre el modal -->
                <div class="text-center mt-10">
                    <button type="button"
                        onclick="document.getElementById('deleteModal').classList.remove('hidden')"
                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded-full transition">
                        Eliminar cuenta
                    </button>
                </div>

                <!-- Modal de confirmación -->
                <div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
                    <div class="bg-white rounded-lg shadow-lg p-6 w-[90%] max-w-md text-[#0C1222] relative">
                        <h3 class="text-xl font-bold mb-4">¿Estás seguro?</h3>
                        <p class="mb-4">Introduce tu contraseña para confirmar la eliminación de tu cuenta.</p>

                        @if ($errors->userDeletion->has('contrasena'))
                            <p class="text-red-500 mb-3 text-sm">
                                {{ $errors->userDeletion->first('contrasena') }}
                            </p>
                        @endif

                        <form method="POST" action="{{ route('account.destroy') }}">
                            @csrf
                            @method('DELETE')
                            <input type="password" name="contrasena" placeholder="Contraseña"
                                class="w-full px-4 py-2 rounded border border-gray-300 mb-4" required>

                            <div class="flex justify-end gap-4">
                                <button type="button" onclick="document.getElementById('deleteModal').classList.add('hidden')"
                                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded">
                                    Cancelar
                                </button>

                                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">
                                    Eliminar cuenta
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.authenticated>
