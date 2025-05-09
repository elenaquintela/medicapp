<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro – MedicApp</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0C1222] text-white min-h-screen font-sans flex flex-col justify-between">

    <!-- Header con logo -->
    <x-header />
    <!-- Formulario centrado -->
    <main class="flex-grow flex items-center justify-center">
        <div class="w-full max-w-md px-8">
            <h2 class="text-2xl font-bold text-center mb-8">Nuevo usuario</h2>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Nombre -->
                <div>
                    <label for="name" class="block mb-1 text-lg">Nombre</label>
                    <input id="name" name="name" type="text" required autofocus value="{{ old('name') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222] focus:outline-none focus:ring-2 focus:ring-blue-400">
                    @error('name')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block mb-1 text-lg">Correo electrónico</label>
                    <input id="email" name="email" type="email" required value="{{ old('email') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222] focus:outline-none focus:ring-2 focus:ring-blue-400">
                    @error('email')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contraseña -->
                <div>
                    <label for="password" class="block mb-1 text-lg">Contraseña</label>
                    <input id="password" name="password" type="password" required
                           class="w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222] focus:outline-none focus:ring-2 focus:ring-blue-400">
                    @error('password')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmar contraseña -->
                <div>
                    <label for="password_confirmation" class="block mb-1 text-lg">Confirmar contraseña</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                           class="w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222] focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <!-- Botón -->
                <div class="text-center">
                    <button type="submit"
                            class="bg-yellow-300 text-[#0C1222] font-bold text-lg px-8 py-3 rounded-full hover:bg-yellow-200 transition mt-8">
                        Registrarse
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <x-footer />

</body>
</html>
