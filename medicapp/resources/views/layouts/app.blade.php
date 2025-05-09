<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name', 'MedicApp') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0C1222] text-white min-h-screen font-sans flex flex-col">

    {{-- Header personalizado --}}
    <x-auth-header 
    :perfilesUsuario="$perfilesUsuario ?? []" 
    :perfilActivo="$perfilActivo ?? null" />

    {{-- Contenido principal --}}
    <main class="flex-1">
        {{ $slot }}
    </main>

    {{-- Footer personalizado --}}
    <x-footer />
    
</body>
</html>
