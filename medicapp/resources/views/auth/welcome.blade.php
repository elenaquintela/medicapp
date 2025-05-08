<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>MedicApp – Iniciar sesión</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0C1222] text-white min-h-screen font-sans">

    <div class="flex items-center justify-center min-h-screen relative">
        <div class="flex w-full max-w-6xl bg-[#0C1222] rounded-lg shadow-lg overflow-hidden">

            <!-- Lado izquierdo -->
            <div class="w-1/2 p-12 flex flex-col justify-center space-y-6">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-yellow-300 rounded-full"></div>
                    <div class="w-8 h-8 bg-sky-400 rounded-full"></div>
                    <h1 class="text-3xl font-bold ml-2">MedicApp</h1>
                </div>

                <!-- Texto principal -->
                <h2 class="text-3xl font-bold">Tu medicación, siempre a tiempo</h2>

                <p class="text-lg leading-relaxed">
                    MedicApp te recuerda cada toma,<br>
                    organiza tus <span class="text-yellow-300">citas médicas</span> y guarda
                    todo tu <span class="text-yellow-300">tratamiento</span> en un solo lugar…
                    <br>para que tú solo te dediques a <span class="text-yellow-300">vivir</span>.
                </p>

                <a href="{{ route('register') }}"
                   class="bg-yellow-300 text-[#0C1222] font-bold py-3 px-10 rounded-full w-fit hover:bg-yellow-200 transition">
                    Comenzar
                </a>
            </div>

            <!-- Lado derecho: login -->
            <div class="w-1/2 bg-white text-[#0C1222] p-12 flex flex-col justify-center border-4 border-yellow-300 rounded-r-lg">
                <h2 class="text-xl text-center mb-1">¿Ya tiene una cuenta?</h2>
                <h3 class="text-2xl font-bold text-center mb-6">Iniciar sesión</h3>

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block mb-1 font-semibold">Correo electrónico</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full px-4 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('email')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block mb-1 font-semibold">Contraseña</label>
                        <input id="password" type="password" name="password" required
                               class="w-full px-4 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('password')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botón -->
                    <div class="text-center mt-6">
                        <button type="submit"
                                class="bg-yellow-300 text-[#0C1222] font-bold px-10 py-3 rounded-full hover:bg-yellow-200 transition">
                            Acceder
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <footer class="absolute bottom-0 left-0 right-0 bg-[#3F423D] text-white text-sm text-center py-2">
            Aviso legal &nbsp;&middot;&nbsp; Política de privacidad &nbsp;&middot;&nbsp; Política de cookies
        </footer>
    </div>

</body>
</html>
