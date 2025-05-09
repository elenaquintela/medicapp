<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo perfil – MedicApp</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0C1222] text-white min-h-screen font-sans flex flex-col justify-between">

    <!-- Header -->
    <x-header />

    <!-- Formulario -->
    <main class="flex-grow flex items-center justify-center">
        <div class="w-full max-w-2xl px-8">
            <h2 class="text-3xl font-bold text-center mb-10">Datos del paciente</h2>

            <form method="POST" action="{{ route('perfil.store') }}" class="space-y-6">
                @csrf

                <!-- Nombre del perfil -->
                <div>
                    <label for="nombre_paciente" class="block mb-1 text-lg">Nombre</label>
                    <input id="nombre_paciente" name="nombre_paciente" type="text" required
                           class="w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222] focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <!-- Fecha de nacimiento -->
                <div>
                    <label for="fecha_nacimiento" class="block mb-1 text-lg">Fecha de nacimiento</label>
                    <input id="fecha_nacimiento" name="fecha_nacimiento" type="date" required
                           class="w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222] focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <!-- Sexo -->
                <div>
                    <label for="sexo" class="block mb-1 text-lg">Género</label>
                    <select id="sexo" name="sexo" required
                            class="w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222] bg-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="F">Mujer</option>
                        <option value="M">Hombre</option>
                        <option value="NB">No binario</option>
                        <option value="O">Otro</option>
                    </select>
                </div>

                <!-- Causa del tratamiento -->
                <div>
                    <label for="causa" class="block mb-1 text-lg">Causa de tratamiento</label>
                    <input id="causa" name="causa" type="text" required
                           class="w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222] focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <!-- Botón -->
                <div class="text-center mt-8">
                    <button type="submit"
                            class="bg-yellow-300 text-[#0C1222] font-bold text-lg px-10 py-3 rounded-full hover:bg-yellow-200 transition">
                        Crear perfil
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <x-footer />
</body>
</html>