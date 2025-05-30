@props(['perfilesUsuario', 'perfilActivo' => null])

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'MedicApp' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0C1222] text-white min-h-screen h-screen font-sans flex flex-col justify-between">
    
    <!-- Cabecera -->
    @auth
        <x-auth-header 
            :perfilesUsuario="$perfilesUsuario ?? []" 
            :perfilActivo="$perfilActivo ?? null" 
        />
    @endauth

    <!-- Contenido principal -->
    <div class="flex flex-grow">
        @auth
            <x-sidebar />
        @endauth

        <main class="flex-1 p-4">
            {{ $slot }}
        </main>
    </div>

    <!-- Pie -->
    <x-footer />
</body>
</html>
