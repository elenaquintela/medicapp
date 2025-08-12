<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MedicApp') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0C1222] text-white min-h-screen font-sans flex flex-col">

    {{-- Header personalizado --}}
    <x-auth-header 
    :perfilesUsuario="$perfilesUsuario ?? []" 
    :perfilActivo="$perfilActivo ?? null" />


    {{-- Contenido principal --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer siempre visible --}}
    <x-footer />
    
</body>
</html>
